class StatisticsController < ApplicationController

	def new
		@loggedIn = session[:user_name]!=nil
		@userCount = User.count()
		@trackCount = TimeTracker.count()
	end

	def create
		returnAry = Array.new
		datetime = Time.now.strftime("%d/%m/%Y %H:%M")
		datetimesplt = datetime.split(" ")
		date = datetimesplt[0]
		datesplt = date.split("/")
		day = datesplt[0]
		month = datesplt[1]
		year = datesplt[2]
		if params[:username]!=""
			results = TimeTracker.where(:username => params[:username])
		else		
			results = TimeTracker.where("username > \"a\"")
		end
			results.each do |p|
   				start = p.start
				startsplt = start.split(" ")
				startdate = startsplt[0]
				startdatesplt = startdate.split("-")
				startday = startdatesplt[2]
				startmonth = startdatesplt[1]
				startyear = startdatesplt[0]
				if params[:typ]=="day"
					if startday==day and startyear==year
						returnAry.push(Hash["comment"=>p.comment, "type"=>p.typ, "start"=>p.start, "finish"=>p.finish, "user"=> p.username])
					end
				end	
				if params[:typ]=="month"
					if startmonth==month and startyear==year
						returnAry.push(Hash["comment"=>p.comment, "type"=>p.typ, "start"=>p.start, "finish"=>p.finish, "user"=> p.username])
					end
				end	
				if params[:typ]=="year"
					if startyear==year
						returnAry.push(Hash["comment"=>p.comment, "type"=>p.typ, "start"=>p.start, "finish"=>p.finish, "user"=> p.username])
					end
				end	
			end
		flash[:results]=returnAry
		redirect_to "/stats"
	end
end
