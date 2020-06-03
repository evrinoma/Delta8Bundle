Ovveride base menu<br>
delta8:<br>
  menu: App\Menu\LiveVideoMenu
  
or register new instance in file service.yml<br>
App\Menu\Delta8Menu:<br>
  tags:
    - { name: evrinoma.menu }
 