import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, ToastController } from 'ionic-angular';
import { FormGroup, Validators, FormBuilder } from '@angular/forms';
import { Http, Headers, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/map';

@IonicPage()
@Component({
  selector: 'page-mesa',
  templateUrl: 'mesa.html',
})
export class MesaPage {
	
	/* DEFINE EL FORMULARIO Y LOS CAMPOS */
	public form : FormGroup;
	public mesaCarrera : any;
	public mesaAsignatura : any;
	public mesaDocente : any;
	/* DEFINE LOS ARREGLOS NECESARIOS PARA CARGAR EL FORMULARIO (DESDE LA BD) */
	public carreras : any = [];
	public mesas : any = [];
	/* DEFINE LA CONEXION CON EL SERVIDOR */
	public url : string = "http://192.168.1.39/ionic/tempus.php";

	constructor(public navCtrl: NavController, 
				public navParams: NavParams,
				public http: Http,
				public formBuilder: FormBuilder, 
				public toastController: ToastController) {
		/* REALIZA LA CREACION CON LAS CARACTERISTICAS A VALIDAR */
		this.form = formBuilder.group({
         "carrera"     : ["", Validators.required],
         "asignatura"  : ["", Validators.required],
		 "docente"        : ["", Validators.compose([Validators.required])]
      });
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
	
	consultarMesas() {
		console.log('consultarMesas MesaPage');
		if(this.form.valid) {
			console.log('consultarMesas MesaPage formulario valido');
			
			let carrera    : string = this.form.controls["carrera"].value,
			asignatura : string = this.form.controls["asignatura"].value,
			body       : string = "key=buscarMesa&carrera="+carrera+"&asignatura="+asignatura,
			type       : string = "application/x-www-form-urlencoded; charset=UTF-8",
			headers    : any    = new Headers({ 'Content-Type': type}),
			options    : any    = new RequestOptions({ headers: headers }),
			url        : any    = this.url;
			
			this.http.post(url, body, options)
			.subscribe(data =>
			{
			  /* ---SE DEBE BORRAR --- */
			  console.log(data.json());
			  
				if(data.status === 200) {
				  /* SE HA OBTENIDO RESULTADO. ASIGNA EL RESULTADO DE LA CONSULTA A LAS MESAS  */
				  this.mesas = data.json();
				  
				} else {
					this.enviarNotificacion("No se pudo procesar la petición");
				}
			});
		} else {
			console.log('consultarMesas MesaPage formulario invalido');
			this.enviarNotificacion('El formulario contiene información incorrecta');
		}
	}
	
	/* ENVIA UNA NOTIFICACION QUE RECIBE POR PARAMETRO. */
	enviarNotificacion(mensaje) :void 
	{
		let notification = this.toastController.create({
			message       : mensaje,
			duration      : 3000
		});
		notification.present();
	}

}
