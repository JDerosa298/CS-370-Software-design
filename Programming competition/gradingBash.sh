#!/bin/bash
#checking if the file exists
$fileName
if [ -e $1 ]
then    #checking if the  file  is a python file
        fileName=$(basename "$1")
        if [ ${1: -3} ==  ".py"  ]
        then
        #running  / grading the program
        docker cp $1  pycontainer:home/
        docker start pycontainer > /dev/null 2>&1
                if [ ${2: -3} == ".py"  ]
                then
                        docker exec pycontainer python /home/$fileName | python $2
                elif [  ${2: -2} == ".c" ] || [ ${2: -4} == ".cpp" ]
                then
                        gcc $2
                        docker exec pycontiner python /home/$filename | ./a.out $2
                fi
        #checking if the file is a c file
        elif [  ${1: -2} == ".c"  ] || [  ${1: -4} == ".cpp"  ]
        then
        #running / grading the program
        docker cp $1 c_container:home/
        docker start c_container > /dev/null 2>&1
                if [ ${2: -3} == ".py" ] 
                then
                        docker exec c_container gcc /home/$fileName && docker exec c_container ./a.out | python $2
                elif [ ${2: -2} == ".c" ] || [ ${2: -4} == ".cpp" ]
                then
                        gcc $2
                        docker exec c_container gcc /home/$filename | ./a.out $2
                fi
        fi
fi
