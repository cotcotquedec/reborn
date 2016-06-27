#!/bin/sh

echo "-----------------------"
echo "FrenchFrogs : framework"
echo "-----------------------"

if ! [ -d vendor/frenchfrogs/framework ]
then
    echo "=> Vous n'utilisez pas frenchfrogs, desolé"
    exit 0
fi

cd vendor/frenchfrogs/framework

if ! [ -d .git ]
then
   git init
   git remote add origin git@github.com:FrenchFrogs/framework.git
   git fetch origin
   git pull origin master
   git checkout -t origin/master -f

   echo " => Git init OK"
fi

git pull


echo "-----------------------"
echo "FrenchFrogs : ACL"
echo "-----------------------"

if ! [ -d ../acl ]
then
    echo "=> Vous n'utilisez pas ACL, desolé"
else
    cd ../acl

    if ! [ -d .git ]
    then
       git init
       git remote add origin git@github.com:FrenchFrogs/acl.git
       git fetch origin
       git pull origin master
       git checkout -t origin/master -f

       echo " => Git init OK"
    fi

    git pull
fi




echo "----------------------------"
echo "FrenchFrogs : Demultiplexer"
echo "----------------------------"


if ! [ -d ../demultiplexer ]
then
    echo "=> Vous n'utilisez pas Demultiplexer, desolé"
else
    cd ../demultiplexer

    if ! [ -d .git ]
    then
       git init
       git remote add origin git@github.com:FrenchFrogs/demultiplexer.git
       git fetch origin
       git pull origin master
       git checkout -t origin/master -f

       echo " => Git init OK"
    fi

    git pull
fi

echo "----------------------------"
echo "FrenchFrogs : Media"
echo "----------------------------"


if ! [ -d ../media ]
then
    echo "=> Vous n'utilisez pas Media, desolé"
else
    cd ../media

    if ! [ -d .git ]
    then
       git init
       git remote add origin git@github.com:FrenchFrogs/media.git
       git fetch origin
       git pull origin master
       git checkout -t origin/master -f

       echo " => Git init OK"
    fi

    git pull
fi


echo "----------------------------"
echo "FrenchFrogs : Scheduler"
echo "----------------------------"



if ! [ -d ../scheduler ]
then
    echo "=> Vous n'utilisez pas Scheduler, desolé"
else
    cd ../scheduler

    if ! [ -d .git ]
    then
       git init
       git remote add origin git@github.com:FrenchFrogs/scheduler.git
       git fetch origin
       git pull origin master
       git checkout -t origin/master -f

       echo " => Git init OK"
    fi

    git pull
fi


echo "----------------------------"
echo "FrenchFrogs : Tag"
echo "----------------------------"


if ! [ -d  ../tag ]
then
    echo "=> Vous n'utilisez pas Tag, desolé"
else
    cd ../tag

    if ! [ -d .git ]
    then
       git init
       git remote add origin git@github.com:FrenchFrogs/tag.git
       git fetch origin
       git pull origin master
       git checkout -t origin/master -f

       echo " => Git init OK"
    fi

    git pull
fi


echo "----------------------------"
echo "FrenchFrogs : Tracker"
echo "----------------------------"

if ! [ -d  ../tag ]
then
    echo "=> Vous n'utilisez pas Tracker, desolé"
else
    cd ../tracker

    if ! [ -d ../tag ]
    then
       git init
       git remote add origin git@github.com:FrenchFrogs/tracker.git
       git fetch origin
       git pull origin master
       git checkout -t origin/master -f

       echo " => Git init OK"
    fi

    git pull
fi



echo "----------------------------"
echo "FrenchFrogs : Scheduler"
echo "----------------------------"


if ! [ -d  ../scheduler ]
then
    echo "=> Vous n'utilisez pas Scheduler, desolé"
else
    cd ../scheduler

    if ! [ -d .git ]
    then
        git init
        git remote add origin git@github.com:FrenchFrogs/scheduler.git
        git fetch origin
        git pull origin master
        git checkout -t origin/master -f

        echo " => Git init OK"
    fi

    git pull
fi




echo "----------------------------"
echo "FrenchFrogs : Référence"
echo "----------------------------"


if ! [ -d  ../scheduler ]
then
    echo "=> Vous n'utilisez pas Référence, desolé"
else
    cd ../reference

    if ! [ -d .git ]
    then
        git init
        git remote add origin git@github.com:FrenchFrogs/reference.git
        git fetch origin
        git pull origin master
        git checkout -t origin/master -f

        echo " => Git init OK"
    fi

    git pull
fi



echo "----------------------------"
echo "FrenchFrogs : Maker"
echo "----------------------------"


if ! [ -d  ../maker ]
then
    echo "=> Vous n'utilisez pas Maker, desolé"
else
    cd ../maker

    if ! [ -d .git ]
    then
        git init
        git remote add origin git@github.com:FrenchFrogs/maker.git
        git fetch origin
        git pull origin master
        git checkout -t origin/master -f

        echo " => Git init OK"
    fi

    git pull
fi