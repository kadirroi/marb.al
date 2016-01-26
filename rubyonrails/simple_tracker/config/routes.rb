SimpleTracker::Application.routes.draw do

	root :to => "mainpage#main"
	match "login", :to => "sessions#new"
	match "signup", :to => "users#new"
	match "tracker", :to => "time_trackers#new"
	match "logout", :to => "users#logout"
	match "stats", :to => "statistics#new"
	resources :users
	resources :time_trackers
	resources :sessions
	resources :statistics

end
