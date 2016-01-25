class CreateTimeTrackers < ActiveRecord::Migration
  def change
    create_table :time_trackers do |t|
      t.string :comment
      t.string :type
      t.string :start
      t.string :finish
      t.string :username

      t.timestamps
    end
  end
end
