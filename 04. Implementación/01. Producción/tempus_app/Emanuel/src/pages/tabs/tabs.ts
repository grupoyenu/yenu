import { Component } from '@angular/core';

import { CursadaPage } from '../cursada/cursada';
import { MesaPage } from '../mesa/mesa';
import { FavoritoPage } from '../favorito/favorito';
import { NotificacionPage } from '../notificacion/notificacion';


@Component({
  templateUrl: 'tabs.html',
})
export class TabsPage {

  tab1Root = CursadaPage;
  tab2Root = MesaPage;
  tab3Root = FavoritoPage;
  tab4Root = NotificacionPage;

  constructor() {

  }

}
