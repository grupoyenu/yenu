import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, ToastController } from 'ionic-angular';
import { FormGroup, Validators, FormBuilder } from '@angular/forms';
import { Http, Headers, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/map';


@IonicPage()
@Component({
  selector: 'page-cursada',
  templateUrl: 'cursada.html',
})
export class CursadaPage {
	
	public form : FormGroup;
	public cursadaCarrera : any;
	public cursadaAsignatura: any;
	public cursadaAnio : any;
	public cursadas : any = [];
	
	// IDENTIFICADORES PARA LA CARRERA Y ASIGNATURA
	public idasignatura : any = null;
	public idcarrera : any = null;
	
	// URL DEL LOCALHOST 
	public baseURI : string = "http://localhost/ionic/";

	constructor(public navController: NavController, 
				public http: Http, 
				public navParams: NavParams, 
				public formBuilder: FormBuilder, 
				public toastController: ToastController) 
	{			
		/* REALIZA LA CREACION DEL FORMULARIO */
		
		this.form = formBuilder.group({
         "carrera"                  : ["", Validators.required],
         "asignatura"           : ["", Validators.required],
		 "anio"           : ["", Validators.required]
      });
		
	}

	ionViewDidLoad() {
		console.log('ionViewDidLoad CursadaPage');
	}
	
	consultarCursadas() 
	{
		 /* ---SE DEBE BORRAR --- */
		console.log(' Entro al consultarCursadas ');
		
		
		let carrera    : string = this.form.controls["carrera"].value,
			asignatura : string = this.form.controls["asignatura"].value,
			anio       : any    = this.form.controls["anio"].value,
			body       : string = "key=buscarCursada&carrera="+carrera+"&asignatura="+asignatura+"&anio="+anio,
			type       : string = "application/x-www-form-urlencoded; charset=UTF-8",
			headers    : any    = new Headers({ 'Content-Type': type}),
			options    : any    = new RequestOptions({ headers: headers }),
			url        : any    = this.baseURI + "tempus.php";

      this.http.post(url, body, options)
      .subscribe(data =>
      {
		  /* ---SE DEBE BORRAR --- */
		  console.log(data.json());
		  
		  if(data.status === 200) {
			  
			  /* SE HA OBTENIDO RESULTADO. ASIGNA EL RESULTADO DE LA CONSULTA A LAS CURSADAS  */
			  this.cursadas = data.json();
			  
		  } else {
			  this.enviarNotificacion("No se pudo procesar la petición");
		  }
      });
	}
	
	/*
	 * ENVIA UNA NOTIFICACION QUE RECIBE POR PARAMETRO. 
	 */
	enviarNotificacion(mensaje) :void 
	{
		let notification = this.toastController.create({
			message       : mensaje,
			duration      : 3000
		});
		notification.present();
	}

}
