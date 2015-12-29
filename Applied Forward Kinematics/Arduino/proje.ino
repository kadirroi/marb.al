#include <Servo.h>

Servo servo1,servo2;

void goToCoord(int width, int height){
 
  // width <= 24
  // alfa : [60,80]
  // teta : [60,90[
  
  Serial.println("Calculating alfa and teta");
  
  int alfa,teta;
  
  int bestAlfa, bestTeta;
  
  int curHeightDiff,curWidthDiff;
  
  int curDiff,bestDiff;
  
  int curHeight, curWidth;
  
  curHeight = findHeight(60,60);
  curWidth = findWidth(60,60);
  bestAlfa = 60;
  bestTeta = 60;
  curWidthDiff = abs(width-curWidth);
  curHeightDiff = abs(height-curHeight);
  curDiff = (curWidthDiff+1) * (curHeightDiff+1);
  bestDiff = curDiff;
  
  Serial.print("(bestAlfa, bestTeta, bestDiff) : (");
  Serial.print(bestAlfa);
  Serial.print(" ,");
  Serial.print(bestTeta);
  Serial.print(" ,");
  Serial.print(bestDiff);
  Serial.println(")");
  
  for (alfa=61;alfa<=80;alfa++){
    for (teta=61;teta<90;teta++){
      curHeight = findHeight(alfa,teta);
      curWidth = findWidth(alfa,teta);   
      curWidthDiff = abs(width-curWidth);
      curHeightDiff = abs(height-curHeight);
      curDiff = (curWidthDiff+1) * (curHeightDiff+1);
      if (curDiff < bestDiff){
         bestDiff = curDiff;
         bestAlfa = alfa;
         bestTeta = teta;
         
         Serial.print("(bestAlfa, bestTeta, bestDiff) : (");
         Serial.print(bestAlfa);
         Serial.print(" ,");
         Serial.print(bestTeta);
         Serial.print(" ,");
         Serial.print(bestDiff);
         Serial.println(")");
      }
      
    } 
  }
  
  goToDegree(bestAlfa,bestTeta);
  
}

void goToDegree(int alfa, int teta){
  
  servo1.write(mapservo1(alfa));
  delay(2000);
  servo2.write(teta);
  delay(2000);
  
}

void printEstimatedCoord(int alfa, int teta){
  
  int estimatedWidth = findWidth(alfa,teta);
  int estimatedHeight = findHeight(alfa,teta);
  
  Serial.print("Estimated width : ");
  Serial.println(estimatedWidth);
  Serial.print("Estimated height : ");
  Serial.println(estimatedHeight);
  
}

int findWidth(int alfa, int teta){
 
  //alfa servo1 -- teta servo2 icin
  int originWidth = 24;
  
  int height = originWidth-(((90-teta)*0.5)/5);

  int alfatmp = 90-alfa;
  
  double tangent = tan(0.0174532925 * alfatmp);
  
  int dy = 47*tangent;
 
  double tangent2 =  tan(0.0174532925 * teta);
  
  int dx = dy/tangent2;
  
  height -= dx;
  
  if (alfa/10==6){
   
    if (alfa<65){
      if (teta<=85)
        height -= 3;
      if (teta<70)
        height -=3;
    }
    else
      if (teta<=85)
            height -=4;
   
  }
  
  return height;
  
  
}

int findHeight(int alfa, int teta){
 
  // alfa servo1 -- teta servo2 icin
  
  int alfatmp = 90-alfa;
  
  double tangent = tan(0.0174532925 * alfatmp);
  
  int height = (47*tangent)+7;
  
  double sinus = sin(0.0174532925 * teta);
  
  if (alfa/10==7){
    int result = int(height*sinus);
    int correction = int((24*12)/teta);
    result -= correction;
    return result;
  }
  if (alfa/10==8){
   
    int result = int(height*sinus)-7;
    return result; 
  }
  
  return int(height*sinus);
  
}

int mapservo1(int deg){
 
  return deg+8;
  
}

void setup(){

  Serial.begin(9600);
  
  
  servo2.attach(9);
  servo1.attach(7);
  
 
  servo1.write(90);
  delay(2000);
  servo2.write(90);
  delay(2000);
  
  Serial.println("Initialization done");
  
  while (true){
   String coordInfos = Serial.readString();
   if (coordInfos!=""){
     Serial.println("Recieved : "+coordInfos);
     String width = String(2);
     String height = String(2); 
     width[0] = coordInfos[0];
     width+= coordInfos[1];
     height[0] = coordInfos[2];
     height+= coordInfos[3];
     Serial.println("Width : "+width);
     Serial.println("Height : "+height);
     
    servo1.write(90);
    delay(2000);
    servo2.write(90);
    delay(2000);
  
    Serial.println("Initialization done");
     
     int widthINT = width.toInt();
     int heightINT = height.toInt();
     Serial.println("Going to coordinates");
     goToCoord(widthINT, heightINT);
   } 
  }
  
  
}

void loop(){
}
