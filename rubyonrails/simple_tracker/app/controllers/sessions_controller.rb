class SessionsController < ApplicationController

	def new
		
	end

	def create
		client = User.find_by_email(params[:email])
		if client == nil
			flash[:error] = "Cannot login"
			redirect_to "/login"
		else
			if params[:password] == client["password"]
				session[:user_name] = client["username"]
				redirect_to "/tracker"			
			else
				flash[:error] = "Cannot login"
				redirect_to "/login"
			end
		end
	end

end
