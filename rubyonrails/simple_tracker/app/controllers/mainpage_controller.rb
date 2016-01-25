class MainpageController < ApplicationController

	def main
		if session[:user_name] != nil
			@loggedin = true
		else
			@loggedin = false
		end
	end
	
end

