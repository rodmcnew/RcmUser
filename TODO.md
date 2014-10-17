# Future Features #

#### Composer Based Install ####

Story:
As a DevOps person
I should be able to install RcmUser using Composer
So that I may install in a standard way

#### More REST/JSON APIs ####

#### Addition Default Views ####

 - my profile
 - login
 - reset password

#### Admin Edit Profile Updates ####

 - User property links on user edit/profile pages:
 
    Story:
    As User when I access a user profile edit page
    I should see a list of links or tabs to other profile data
    So I can have quick access to all my user properties
    
#### Admin Role and Rule UI Updates ####

 - Assign multiple privileges when creating a rule on ACL Administration pages

#### Security Updates ####

 - Logging of actions for security audits

#### DB and Query Optimization ####

 - Optimize mappers
 - Pagination for DataMappers

#### Translations #### 

 - Result messages
 - Translation of other page content

#### Protection of default and special roles ####

As an ACL Administrator
I should not be able to delete super admin, guest or default roles
So that rules for default roles will not be removed

- Should not be able to delete super admin, guest or default roles
- OR should be able to restore them easily (even if they are deleted they are still there)

#### Full Deny rule support ####

Story: 
As a Role Administrator 
I should be able to create Deny rules so 
I may deny a role access

There is an edge case where the results of a deny may not be what is expected.

- Refactor AuthorizeService
- Support getAccess() return type (allow, deny or none) in RcmUserACL extended
- might look at moving some of AuthorizeService into RcmUserACL
- may decouple from ZF2 ACL class

#### Guest User Identity features (maybe) ####

Concept: There is alway a user object tied to session (even if not logged it).
Data may be tracked against the user object properties and may be synced to a user
on log in.

Story: 
As a consumer of RcmUser
I would like to have a guest user that functions just like a non-guest user 
So that guest user and non-gest user objects are seemless

- Guest user/guestIdentity 
- if getIdentity is empty return guest?
    allow save updates in session so we can make updates to guest
- On authenticate, we can try to merge guest user back into auth user
    if session id is the same and should have a flag (only do if requested)
- Guest may have a time limit so we dont cross pollinate wrong guest
- Clear both on log out?
- Might use a event listeners (crud and auth)

#### ACL Exception handling ####
            
Story: 
As a user 
I should be denied access when a role or a resource is not defined withou an exception being thrown
So that my experince is seemless

- May add suppresion of RcmException when a privilege of resource is not found
- May add logging of this error

#### AclResourceService Refactor ####

Story: 
As Developer 
I need to refactor AclResourceService 
So that my code is clean, simple and efficient

- Refactor AclResourceService
- Use service manager for instantiation only (might be that way currently)
- AclResourceService only need deal with ResourceProvider and AclResource objects
- Build ResourceProvider populate method and take array on construct
- Build AclResource populate method and take array on construct