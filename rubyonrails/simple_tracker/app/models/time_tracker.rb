class TimeTracker < ActiveRecord::Base
  attr_accessible :comment, :finish, :start, :typ, :username
end
