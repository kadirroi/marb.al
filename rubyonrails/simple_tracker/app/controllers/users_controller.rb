class UsersController < ApplicationController

	def new
		@user = User.new # this will help us to create a new form for a new Use
	end

	def create
		@user = User.new({:email => params[:email], :password => params[:password], :username => params[:username]})
		if @user.save
			session[:user_name] = @user.username
			redirect_to "/tracker"
		else
			flash[:error] = @user.errors
			redirect_to "/signup" 
		end
	end

	def logout
		session[:user_name] = nil
		redirect_to "/"
	end

end
