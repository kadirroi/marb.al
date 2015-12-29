'''
Tracking cards from different colors with SimpleCV.

Usage:
    python track.py [img|segmented]

Options:
    img            shows the image itself
    segmented      shows binarized image, usefull for setting
                   COLOR_BINARIZATION_THRESHOLD in the settings file

Based on the code from:
http://www.youtube.com/watch?v=jihxqg3kr-g
'''

import time
import sys
import numpy as np
import SimpleCV

from settings import *
import serial 

ser = serial.Serial('/dev/ttyUSB0', 9600)
WIDTH_DATA = []
HEIGHT_DATA = []

def sendDataToArduino(lst):
	width = str(lst[0])
	height = str(lst[1])
	if len(width)==1:
		width = "0"+width
	if len(height)==1:
		height = "0"+height

	dataToSend = width+height
	ser.write(dataToSend)

	print "("+dataToSend+") has been sent to Arduino"

def pixelToCentimeter(x, y):
	#good old brute force
	print "Converting pixel to centimeter.."
	
	#width
	minDiff = abs(x-WIDTH_DATA[0][0])
	minWidthIndex = 0
	for i in range(1,len(WIDTH_DATA)):
		if abs(x-WIDTH_DATA[i][0])<minDiff:
			minDiff = abs(x-WIDTH_DATA[i][0])
			minWidthIndex = i

	#height
	minDiff = abs(y-HEIGHT_DATA[0][0])
	minHeightIndex = 0
	for i in range(1,len(HEIGHT_DATA)):
		if abs(y-HEIGHT_DATA[i][0])<minDiff:
			minDiff = abs(y-HEIGHT_DATA[i][0])
			minHeightIndex = i

	returnList = (WIDTH_DATA[minWidthIndex][1], HEIGHT_DATA[minHeightIndex][1])
	print "Returning centimeter values : "+str(returnList)
	return returnList

def parseData():
	with open("data.txt") as f:
		for line in f:	
			splitData = line.split(",")
			widthData = (int(splitData[0]), int(splitData[2]))
			heightData = (int(splitData[1]), int(splitData[3]))
			WIDTH_DATA.append(widthData)
			HEIGHT_DATA.append(heightData)

def dist_from_color(img, color):
    '''
    SimpleCV.Image, tuple -> int

    tuple: (r, g, b)
    '''

    # BUG in getNumpy, it returns with colors reversed
    matrix = (img.getNumpy()[:, :, [2, 1, 0]] - color) ** 2
    width, height = img.size()
    return matrix.sum() ** 0.5 / (width * height)


def main():
	
    parseData()
	
    print(__doc__)
    cam = SimpleCV.Camera(camera_index=CAMERA_INDEX)
    display = False
    if len(sys.argv) > 1:
        display = sys.argv[1]

    # wait some time for the camera to turn on
    time.sleep(1)
    background = cam.getImage()

    print('Everything is ready. Starting to track!')

    while True:


        raw_input("Press enter to find a blob and point the laser onto it")
        img = cam.getImage()
        dist = ((img - background) + (background - img)).dilate(5)
        # segmented = dist
        segmented = dist.binarize(COLOR_BINARIZATION_THRESHOLD).invert()
        blobs = segmented.findBlobs(minsize=CARD_DIMENSION ** 2)
        if blobs:
            points = []
            b = blobs[0]
            points.append((b.x, b.y))
            car = img.crop(b.x, b.y,
                           CARD_DIMENSION, CARD_DIMENSION, centered=True)
                # color distances from cars
            dists = [dist_from_color(car, c['color']) for c in CARDS]
            choosen_car = CARDS[np.argmin(dists)]['name']
            print(b.x, b.y, choosen_car)
            cmList = pixelToCentimeter(b.x, b.y)
            sendDataToArduino(cmList)
        else :
            print "No blobs found"
        if display:
            to_show = locals()[display]
            if blobs:
                to_show.drawPoints(points)
            to_show.show()
        #else:
        #   time.sleep(0.1)


if __name__ == '__main__':
    main()
