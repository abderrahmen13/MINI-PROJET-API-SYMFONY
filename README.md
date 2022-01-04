1. ADMIN :
    - POST      /api/admin/categorie                (ajouter une categorie)
                EX:
                {
                    "name":"categorie5"
                }
    - GET       /api/admin/consommateurs            (liste des consomateurs)
    - GET       /api/admin/producteurs              (liste des producteurs)
    - PUT       /api/admin/valide_producteur/{id}   (valider un producteur)
2. PRODUCTEUR :
    - GET       /api/producteur/produits            (liste de mes produits)
    - POST      /api/producteur/produit             (ajouter un produit)
                EX:
                {
                    "name":"prod",
                    "image":"image",
                    "date_recolte":"2022-03-11",
                    "quantite":2,
                    "user": 18
                }
    - PUT       /api/producteur/produit/{id}        (modifier un produit)
                EX: 
                {
                    "name":"prod",
                    "image":"image",
                    "date_recolte":"2022-03-11",
                    "quantite":2
                }
    - DELETE    /api/producteur/produit/{id}        (supprimer un produit)
3. CONSOMMATEUR :
    - POST      /api/consommateur/producteurs       (l’ensemble des producteurs de cette localité)      {ville}
                EX: ville: ville 1
    - POST      /api/consommateur/reserver          (réserver un ou plusieurs paniers)
                EX:
                {
                    "produit": [14,15],
                    "date_reservation":"2222-02-02"
                }           
4. AUTHENTIFICATION :
    - POST      /api/login                          (login)

-------------------------------------
1.  php bin/console doctrine:database:create
2.  php bin/console make:migration
3.  php bin/console doctrine:migrations:migrate
4.  php bin/console doctrine:fixtures:load
5.  symfony serve -d