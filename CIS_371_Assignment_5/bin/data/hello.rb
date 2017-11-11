splitQuery = ENV['QUERY_STRING'].split('&')
splitFirst = splitQuery[0].split('=')
splitSecond = splitQuery[1].split('=')

puts ENV['QUERY_STRING']
puts splitQuery
puts splitFirst
puts splitSecond
# if(splitQuery.size < 2)
# 	puts "Please enter your first AND last name."
# else
# 	puts "Hi there "
# 	puts splitFirst[1]
# 	puts " "
# 	puts splitSecond[1]
# 	puts ", this is a hello from an external Ruby process!"
# end