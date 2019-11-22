# PHP5.6 SPL logical redeclaration

By historical reasons in PHP there is a big problem with functions naming.
It's hard to remember functions names.

So i try to structure functions and constants by related classes and namespaces.

**N.B**  But it is impossible to redeclarate following items:

functions

- isset() //check variable definition in local scope
- unset() //delete variable link name in local scope

constants

- \__LINE__ //current executing file line
- \__FILE__ //current executing file
- \__DIR__ //current executing file dir
- \__FUNCTION__ //current executing function
- \__CLASS__ //current executing class (full - with namespace)
- \__TRAIT__ //current executing trait (full - with namespace)
- \__METHOD__ //current executing methode (full - with namespace)
- \__NAMESPACE__ //current executing namespace

Because theare results and values depends on its location. 