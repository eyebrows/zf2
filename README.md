zf2
===

Zend Framework 2 - Initial Experiment
=====================================

Just a simple project to play with ZF2, see how it does things, and figure out how best to get a Data Mapper pattern running for the "M" in MVC, factoring in things such as readibility, ease of use, and minimal boilerplate code

A to-do list exists in ~/public/index.php for now, and there are comments in various places detailing certain decisions and structures

Currently sports custom PDO database accessor, Mapper-Model pattern for data access itself, lazy loading placeholders for referenced/dependent objects, and *much* tidier (although more boilerplate-y) layout of Model and Mappers over my ZF1 experiment