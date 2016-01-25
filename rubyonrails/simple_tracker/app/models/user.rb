class User < ActiveRecord::Base
  attr_accessible :email, :password, :username
  validates :password, :username, :email, :presence => true
  validates :username, :length => { :minimum => 5 }
  validates :password, :length => { :minimum => 8 }
  validates :username, :email, :uniqueness => true
end
