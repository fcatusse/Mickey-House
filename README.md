# End of training project

In this project, we created a web app allowing people to sell meals and to buy meals from others.
The aim of this project was to get familiar with the Agile methodology, version control and collaborative work with Git, and unit tests.

## Features

### Core features

* One "user profile", the user can be both a cook and a consumer.
* Non registered users can see the dishes, but only registered users can post and order dishes.
* A cook can post a dish, edit it, and remove it from the available dishes.
* Dishes belong to categories that are administrated by the user.
* All dishes can be seen on the home page. Clicking on a dish opens a page where it is possible to order it.
* A user can order a dish. (In this concept, the delivery happens IRL between the user and the cook as the user has the cook's address)
* A user can see a history of his orders.
* Every user has a page with his info and the dishes he posted if he did so.

### Additional features

* A system of reviews: 24h after a dish, the user receives an email that asks him to rate the dish he ordered. He can then go on the website, write a review and rate the dish.
* The dish ratings create a rating for the cook.


### Nice to have Features

* The dishes are located on a map, allowing the user to see how close or far they are from him.
* The dishes are ordered according to how close to the user they are.
* Users can follow other users and be notified when they post a new dish or when a dish is available again.

## Database

The database is composed of :
* Users
* Categories
* Dishes
* Orders
* Reviews

## Built With

* [Laravel](https://laravel.com/) - The web framework used
* [MySQL](https://www.mysql.com/fr/)


## Authors

* **Edouard Boivin**
* **François Catusse**
* **Camille Clipet** [camille-dev](https://github.com/camille-dev)
* **Julie Bianchin**
* **Habib Redissi**


## License

This project is licensed under ___ License - see the [LICENSE.md](LICENSE.md) file for details
