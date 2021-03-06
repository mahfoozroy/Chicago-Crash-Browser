Chicago Crash Browser
=====================

[Demo the Chicago Crash Browser](http://chicagocrashes.org/index.php#lat=41.857719&lon=-87.661216&get=yes&zoom=18) - will load the intersection of 18th Street and Blue Island Avenue. 

The Chicago Crash Browser is an interface for the automobile crash data from the Illinois Department of Transportation (IDOT). Crash data for Chicago in 2005-2011 where a bicyclist or pedestrian was the first point of impact by a driver's automobile, as collected by responding law enforcement and maintained by IDOT.

##Purpose
The purpose of the Crash Browser is two fold:

1. Give planners, politicians, and policy makers the tools and information they need to make good decisions and prioritization about where to make investments about transportation safety. 

2. Give activists and advocates the information they need to demand change in the transportation system in the most effective way. 

##Enhancements
Desired enhancements include:
* Speeding up the PostGIS tables
* Joining the "CrashExtract" table with the "PersonExtract" table so the full number of bicyclists and pedestrians are counted in the figures returned to the user for their point search. Alternative: After the crash "casenumbers" (unique ID) are returned, send a query to the "PersonExtract" table once per casenumber to get the person information (this might be faster than joining)
* Usability enhancements that tell the user the database is running their search; show how much time a search has taken; reverse geocodes the searched coordinates
* Style changes
* Update the API to return details like the number of rows returned and the time it took for the PostgreSQL server to run the query
* Close the popup when the search results are returned (for some reason I cannot figure this out, and I thought it was pretty simple)
* Make it responsive
* Count the number of crashes per year and give the bike/pedestrian numbers in a year by year breakdown
* "Bookmark" the locations so a person can create a text list of locations and their resulting crash figures. This is so a user can create a report of several intersections for their neighborhood. 

##Data
The Chicago Crash Browser uses only one of the three tables the state provides, called "CrashExtract". It's called this because the crash data is an extract from the entire database, extracted by year and city. Whenever the whole state was provided, all cities except Chicago ("City Code" != 1051) were stripped and uploaded to a PostgreSQL PostGIS-enabled database. 

The data was removed on March 4, 2015, upon the request of the Illinois Department of Transportation, which cited  sections of the Illinois Vehicle Code.

* [Data dictionary, 2004-2012](datadictionary/2004-present_crash_datadictionary_10-13-09.docx)
* [Data dictionary, 2013-present](datadictionary/Illinois%20Traffic%20Crash%20Data%20Extract%20Metadata%20112014-Crash.docx)

##API
The API returns JSON and has the following GET parameters:
* distance (in feet). This is capped at 1,000 feet. 
* north, south, east, west (to create a bounding box inserted as a WHERE statement to reduce the dataset search time)
* lat (latitude)
* lng (longitude)

Example call
````
api.php?lat=41.85755162802421&lng=-87.64665126800537&north=41.86975344657134&south=41.84533324486843&east=-87.62577295303345&west=-87.66748666763306&distance=150
````

In the webpage, the bounds are obtained via Leaflet. 

The records' WGS84 (EPSG:4326) coordinates are converted to EPSG:3436 (Illinois StatePlane West feet) to be able to search distance in feet (this may not be the best method). This is the data's original projection although the records' WGS84 coordinates (provided by the data author) are the actual fields used.

##History
* First Chicago bike crash map created in February 2011
* Derek Eder created an enhanced version a bit later
* Lots of press for the Chicago bike crash map in 2011
* Attempted to create a public browser later in 2011, to get more details about the crashes, especially after I obtained additional years of data

##Credits##
* Smart Chicago Collaborative for hosting the site
* Michael Carney and Sebastian Lew (who got me interested in automobile crash data in the first place after they asked if I had it)
* Lori M. at IDOT (for providing the data)
* Jerad Weiner
* Amanda Woodall at Active Transportation Alliance (for helping me understand the data)
* Derek Eder and Nick Rougeux (for continued tech support and brainstorming)
* Cory Mollett (for PostgreSQL and Amazon Web Services help)
* Ryan Lakes (for motivating me to resurrect this)
* Nabil Nazha (for assistance in developing a method relating intersections to bike crashes in GIS and determining the ideal distance)
* Bill Vassilakis
* Trina Chiasson
* Richard Lee who made the first edits via GitHub. 
* Robert Guico who installed Bower (for dependencies) and cleaned up a lot of the JavaScript
* Everyone who appreciates this work.

##Cities outside Chicago##
I have no plans to include cities outside Chicago because of the amount of work it takes cleaning up the state's data.
