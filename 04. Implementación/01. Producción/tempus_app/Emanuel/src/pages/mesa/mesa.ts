import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { Http, Headers, RequestOptions } from '@angular/http';

@IonicPage()
@Component({
  selector: 'page-mesa',
  templateUrl: 'mesa.html',
})
export class MesaPage {
	
	public carreras : any = [];
	public url : string = "http://localhost/ionic/tempus.php";

	constructor(public navCtrl: NavController, 
				public navParams: NavParams,
				public http: Http) {
	}

	ionViewDidLoad() {
		console.log('ionViewDidLoad MesaPage');
		this.consultarCarreras();
	}
	
	consultarCarreras() {
		console.log('consultarCarreras MesaPage');
		
		let body       : string = "key=carreras",
			type       : string = "application/x-www-form-urlencoded; charset=UTF-8",
			headers    : any    = new Headers({ 'Content-Type': type}),
			options    : any    = new RequestOptions({ headers: headers }),
			url        : any    = this.url;
			
		this.http.post(url, body, options).subscribe(data =>
		{
		  /* ---SE DEBE BORRAR --- */
		  console.log(data.json());
		  
		  if(data.status === 200) {
			  this.carreras = data.json();
			  
		  } else {
			  console.log("No se pudo procesar la petición");
		  }
      });
	}

}
