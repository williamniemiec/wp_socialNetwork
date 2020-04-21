# [Website Project] Social Network
![socialNetwork logo](https://github.com/williamniemiec/wp_socialNetwork/blob/master/media/logo/logo.png?raw=true)

This is a project about a social network. Its aims is not to be a complete social network, however it can serve as a basis for building one. This project uses [MVC design pattern](https://github.com/williamniemiec/MVC-in-PHP), made in PHP.

<hr />

## To be implemented in future versions
- Private groups
- Chat
- Search by groups
- Profile photo

## Requirements
- jQuery
- Bootstrap 4
- Font awesome

## Project organization
### UML
![uml_diagram](https://github.com/williamniemiec/wp_socialNetwork/blob/master/media/uml/uml.png?raw=true)

### Database
![db_diagram](https://github.com/williamniemiec/wp_socialNetwork/blob/master/media/db_diagram/db_diagram.png?raw=true)

## Files

### /
|Name| Type| Function
|------- | --- | ----
| .settings| `Directory`| Directory created by IDE
| media | `Directory`| Visual informations about the project
| src | `Directory`| Contains all website files
| .buildpath| `File`| File created by IDE
| .project| `File`| File created by IDE


### /src
|Name| Type| Function
|------- | --- | ----
| assets| `Directory`| Contains all application content files
| controllers | `Directory`| Contains all application controller classes
| core | `Directory`| Contains the classes responsable for the MVC operations
| db | `Directory`| Contains [the database of the application](https://github.com/williamniemiec/wp_socialNetwork/tree/master/src/db)
| models | `Directory`| Contains all application model classes
| vendor| `Directory`| Folder created by [Composer](https://getcomposer.org/) - responsable for classes autoload
| views | `Directory`| Contains all application view classes
| &#46;htaccess| `File`| Responsible for friendly url
| composer&#46;json | `File`| File created by Composer
| config&#46;py | `File`| Website configuration file (Database and website location)
| environment&#46;php | `File`| File responsible for defining which environment is in use
| index&#46;php | `File`| File responsible for starting the website


## Application photos
#### Home (no logged)
![home_noLogged](https://github.com/williamniemiec/wp_socialNetwork/blob/master/media/example/home-noLogged.png?raw=true)
#### Home (logged)
![home_logged](https://github.com/williamniemiec/wp_socialNetwork/blob/master/media/example/home.png?raw=true)

#### Group's page
![group](https://github.com/williamniemiec/wp_socialNetwork/blob/master/media/example/group.png?raw=true)
#### Profile
![profile](https://github.com/williamniemiec/wp_socialNetwork/blob/master/media/example/profile.png?raw=true)
#### Search
![search](https://github.com/williamniemiec/wp_socialNetwork/blob/master/media/example/search.png?raw=true)
