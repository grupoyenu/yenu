import { BrowserModule } from '@angular/platform-browser';
import { HttpModule } from '@angular/http';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';
import { SplashScreen } from '@ionic-native/splash-screen';
import { StatusBar } from '@ionic-native/status-bar';
import { MyApp } from './app.component';
import { CursadaPage } from '../pages/cursada/cursada';
import { MesaPage } from '../pages/mesa/mesa';
import { FavoritoPage } from '../pages/favorito/favorito';
import { NotificacionPage } from '../pages/notificacion/notificacion';
import { TabsPage } from '../pages/tabs/tabs';

@NgModule({
  declarations: [
    MyApp,
	CursadaPage,
	MesaPage,
	FavoritoPage,
	NotificacionPage,
	TabsPage
  ],
  imports: [
    BrowserModule,
	HttpModule,
    IonicModule.forRoot(MyApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
	CursadaPage,
	MesaPage,
	FavoritoPage,
	NotificacionPage,
	TabsPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    {provide: ErrorHandler, useClass: IonicErrorHandler}
  ]
})
export class AppModule {}
