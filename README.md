zf2
===

Zend Framework 2 - Initial Experiment
=====================================

Just a simple project to play with ZF2, see how it does things, and figure out how best to get a Data Mapper pattern running for the "M" in MVC,
factoring in things such as readibility, ease of use, and minimal boilerplate code

A to-do list exists below, and a description of the core files/processes will be here soon too

Currently sports custom PDO database accessor, Mapper-Model pattern for data access itself, lazy loading placeholders for referenced/dependent objects,
and *much* tidier (although more boilerplate-y) layout of Model and Mappers over my ZF1 experiment

To Do
=====
 - next
    - it seems a bit dumb that mappers *must* be injected in to each other - if one object suddenly needs a new relationship to a new table, how the
      hell are you going to find every single place its mapper's used, and go and add the new one in? seems insane...
    - see if we can improve BookMapper's getReferencedEntityIds structure to be inherent somehow
    + make user registration work
       + needs to check if email address already exists
	  + which, as it needs to check the DB, means the validator needs to go in the Mapper, not the Model...
	  + need to encrypt password
	  + and get the "thanks i could help, bro!" message back in there
    + make login/logout work
       + switching up the nav if logged in
       + and logout working
       - from zf1: where can "auth state loader" go so that state doesn't have to be loaded in every single Action of every Controller?
	 needed because atm if you go to a Controller/Action without it, you get the un-authed nav appearing
          - maybe can do the same as with inserting the dbadapter in to the controller...
    - create a proper readme documentation to my approach
    + consider moving all InputFilters on to Forms as they're already there, instead of Mappers... but...
      then there's "model-related" information attached to Forms too. Is that such a bad thing, though? Were a field to be added to an Entity the form'd
      need to be changed anyway...
    - also come up with nice way of doing JOIN-based stuff so only one query is needed for list pages
    - get jquery back in to do my nice Message stuff
 - later
    - use ACLs (probably) to do the user types thing with different pages to admin/authed/non-authed visitors
    - see if can follow this link and create means of getting $dbAdapter injected into all AbstractMappers by default, not needing passing in each instance
       - http://stackoverflow.com/questions/10254574/how-to-get-zend-db-adapter-instance-from-within-a-model-zf2?lq=1
    - figure out how exception catching works so ones thrown from my MVC section by me are caught and not causing an exit;
 - done
    + check ZF1 for list of outstanding things
    + add back in some categories to the DB if they ain't already
       + come up with sensible structure for getting such many-to-many things in the Model, using Mappers to handle the actual logic
          + such as with... categories!
	   x and then demonstrate both ways (Mapper-based logic and Model-based) in the code
	      x not currently possible as it's the Mapper that handles the special shit
	   + perhaps a better pattern would be to have the Model fully intact but provide a shortcut method in Category which calls the others?
	      + yes, have opted for model-based shortcut as it's less insane, and some m-t-m linking tables will have data in them too (e.g. date created)
    + see if anything else can be abstracted down into AbstractMapper/Entity
       + models: fine
       + mappers: insert?
   	   + mappers: update?
       + mappers: delete?
    + when saving any objects make sure to pull in id fields of referenced objects that might've changed
    + stick a few files in more sensible places
       + AbstractEntity
   	   + AbstractMapper
       + CommonServiceFactory
   	   + PdoAdapter
   	   + MasterController
       + all the mappers
    + would also be nice if the $adapter could be made available to all Controllers by default, or at least not have to be called in eachAction
    + get authors displaying in the main listing using the new thing I thought up this morning
       + plan is that the Model can have getDependent and getReferenced methods
       + which the mapper should inject with "placeholders" which should now just be things containing a mapper object and what fields to select on
       + abstractModel containing a getReferenced method which ModelBook would call via its own getAuthor method somehow
 - useful URLs
    - http://zf2.readthedocs.org/en/latest/user-guide/skeleton-application.html
    - http://samsonasik.wordpress.com/2012/08/28/set-default-db-adapter-in-zend-framework-2/
	- http://phpmaster.com/building-a-domain-model/
	- http://phpmaster.com/integrating-the-data-mappers/#comment-27011
	- http://zend-framework-community.634137.n4.nabble.com/Services-Instances-Dependencies-in-ZF2-td4584632.html
