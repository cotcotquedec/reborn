#!/bin/sh

echo "-----------------------"
echo "FrenchFrogs : framework"
echo "-----------------------"

cd vendor/frenchfrogs/framework

if ! [ -d .git ]
then
   git init
   git remote add origin git@github.com:FrenchFrogs/framework.git
   git fetch origin
   git checkout -t origin/master -f

   echo " => Git init OK"
fi

git pull


echo "-----------------------"
echo "FrenchFrogs : ACL"
echo "-----------------------"

cd ../acl

if ! [ -d .git ]
then
   git init
   git remote add origin git@github.com:FrenchFrogs/acl.git
   git fetch origin
   git checkout -t origin/master -f

   echo " => Git init OK"
fi

git pull



echo "----------------------------"
echo "FrenchFrogs : Demultiplexer"
echo "----------------------------"

cd ../demultiplexer

if ! [ -d .git ]
then
   git init
   git remote add origin git@github.com:FrenchFrogs/demultiplexer.git
   git fetch origin
   git checkout -t origin/master -f

   echo " => Git init OK"
fi

git pull


echo "----------------------------"
echo "FrenchFrogs : Media"
echo "----------------------------"

cd ../media

if ! [ -d .git ]
then
   git init
   git remote add origin git@github.com:FrenchFrogs/media.git
   git fetch origin
   git checkout -t origin/master -f

   echo " => Git init OK"
fi

git pull


echo "----------------------------"
echo "FrenchFrogs : Scheduler"
echo "----------------------------"

cd ../scheduler

if ! [ -d .git ]
then
   git init
   git remote add origin git@github.com:FrenchFrogs/scheduler.git
   git fetch origin
   git checkout -t origin/master -f

   echo " => Git init OK"
fi

git pull


echo "----------------------------"
echo "FrenchFrogs : Tag"
echo "----------------------------"

cd ../tag

if ! [ -d .git ]
then
   git init
   git remote add origin git@github.com:FrenchFrogs/tag.git
   git fetch origin
   git checkout -t origin/master -f

   echo " => Git init OK"
fi

git pull


echo "----------------------------"
echo "FrenchFrogs : Tracker"
echo "----------------------------"

cd ../tracker

if ! [ -d .git ]
then
   git init
   git remote add origin git@github.com:FrenchFrogs/tracker.git
   git fetch origin
   git checkout -t origin/master -f

   echo " => Git init OK"
fi

git pull



echo "----------------------------"
echo "FrenchFrogs : Scheduler"
echo "----------------------------"

cd ../scheduler

if ! [ -d .git ]
then
    git init
    git remote add origin git@github.com:FrenchFrogs/scheduler.git
    git fetch origin
    git checkout -t origin/master -f

    echo " => Git init OK"
fi

git pull