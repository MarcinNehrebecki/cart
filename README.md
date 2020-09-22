# cart
## require
    - php7.4
    - mysql
    - composer

## Installation

    - composer install 

## Usage

    - in File Config.php write your connection to data base.
    - load fixtutes on use http response POST "/catalog/"
    
    - show all catalog GET "/catalog/?offset=0"
    - add product on fixture in catalog POST "/catalog/x" x=number in fixrures
    - delete product in catalog DELETE "/catalog/0/id" id=id in table
    - soft delete product in catalog DELETE "/catalog/1/id" id=id in table
    - update product name PUT "/catalogName/id/newName"
    - update product price PUT "/catalogName/id/newPrice"
    
    - show product in cart GET "/cart/"
    - add product in cart POST "/cart/id/" - id=id in table
    - delete product in cart DELETE "/cart/id/" id=id in cart
  