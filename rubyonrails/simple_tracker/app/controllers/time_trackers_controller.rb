class TimeTrackersController < ApplicationController
	def new
		if session[:user_name]==nil
			redirect_to "/"
		else
			@username = session[:user_name]
			@time_tracker = TimeTracker.new
			@oldTracks = TimeTracker.where("username = \""+session[:user_name]+"\"")
		end
	end

	def create
		session[:user_name] = params[:username]
		@time_tracker = TimeTracker.new({:comment => params[:comment], :typ => params[:typ], :start => params[:start], :finish => params[:finish], :username => params[:username] })
		if @time_tracker.save
			redirect_to "/tracker"
		else
			flash[:error] = "An error occured"
			redirect_to "/tracker"
		end
	end
end
