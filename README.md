1. ADMIN :
    - POST      /api/admin/categorie                (ajouter une categorie)                                     <br>
                EX:                                                                                             <br>
                {                                                                                               <br>
                    "name":"categorie5"                                                                         <br>
                }                                                                                               <br>
    - GET       /api/admin/consommateurs            (liste des consomateurs)
    - GET       /api/admin/producteurs              (liste des producteurs)
    - PUT       /api/admin/valide_producteur/{id}   (valider un producteur)
2. PRODUCTEUR :
    - GET       /api/producteur/produits            (liste de mes produits)
    - POST      /api/producteur/produit             (ajouter un produit)                                        <br>
                EX:                                                                                             <br>
                {                                                                                               <br>
                    "name":"prod",                                                                              <br>
                    "image":"image",                                                                            <br>
                    "date_recolte":"2022-03-11",                                                                <br>
                    "quantite":2,                                                                               <br>
                    "user": 18                                                                                  <br>
                }                                                                                               <br>
    - PUT       /api/producteur/produit/{id}        (modifier un produit)                                       <br>
                EX:                                                                                             <br>
                {                                                                                               <br>
                    "name":"prod",                                                                              <br>
                    "image":"image",                                                                            <br>
                    "date_recolte":"2022-03-11",                                                                <br>
                    "quantite":2                                                                                <br>
                }                                                                                               <br>
    - DELETE    /api/producteur/produit/{id}        (supprimer un produit)
3. CONSOMMATEUR :
    - POST      /api/consommateur/producteurs       (l???ensemble des producteurs de cette localit??)      {ville} <br>
                EX: ville: ville 1                                                                              <br>
    - POST      /api/consommateur/reserver          (r??server un ou plusieurs paniers)                          <br>
                EX:                                                                                             <br>
                {                                                                                               <br>
                    "produit": [14,15],                                                                         <br>
                    "date_reservation":"2222-02-02"                                                             <br>
                }                                                                                               <br>
4. AUTHENTIFICATION :
    - POST      /api/login                          (login)

-------------------------------------
1.  php bin/console doctrine:database:create
2.  php bin/console make:migration
3.  php bin/console doctrine:migrations:migrate
4.  php bin/console doctrine:fixtures:load
5.  symfony serve -d