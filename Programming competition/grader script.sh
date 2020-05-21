#!/bin/bash
#place holders for automated input
echo "whats the file name?"
read fileName
echo "whats the grader name?"
read graderName
#checking if the file exists
if [ -e /home/server/programs/$fileName ]
then    #checking if the  file  is a python file
        if [ ${fileName: -3} ==  ".py"  ]
        then
        #running  / grading the program 
        echo "the file you input was a python file called " $fileName
        docker cp /home/server/programs/$fileName  pycontainer:home/ && docker start pycontainer        
        docker exec pycontainer python /home/$fileName  | python /home/server/grading/$graderName
        #checking if the file is a c file
        elif [  ${fileName: -2} == ".c" ]
        then
        #running / grading the program
        echo " the file that you entered was a c file"
        docker cp /home/server/programs/$fileName c_container:home/ && docker start c_container
        docker exec c_container gcc /home/$fileName && docker exec c_container ./a.out | python /home/server/grading/$graderName

        fi
#if the file doesnt exist print the statement below
else
echo "Err FIlE:"  $fileName "doesn't exist"
fi
