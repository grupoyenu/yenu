import { Component } from '@angular/core'; //Para usar componenetes de Angular
import { IonicPage, NavController, NavParams, ToastController } from 'ionic-angular'; //NavController para navegar en distintas paginas
import { FormGroup, Validators, FormBuilder } from '@angular/forms';
import { Http, Headers, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/map';

@IonicPage()
@Component({
  selector: 'page-mesa',
  templateUrl: 'mesa.html',
})
export class MesaPage{ 

    public form : FormGroup;
    //Define variables de mesa.htlm
	public mesaCarrera : any;
	public mesaAsignatura: any;
	public mesaDocente : any;
	public cursadas : any = [];
    public carreras : any = [];
	public mesasE : any = [];
    
    // IDENTIFICADORES PARA LA CARRERA Y ASIGNATURA
	public idasignatura : any = null;
	public idcarrera : any = null;
    public iddocente : any = null;
	
	// URL DEL LOCALHOST 
	public baseURI : string = "http://192.168.0.10:8080/ionic/";
    
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
		 "docente"           : ["", Validators.required]
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
			url        : any    = this.baseURI + "tempus.php";
			
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
    consultarCursada() 
	{
		 /* ---SE DEBE BORRAR --- */
		console.log(' Entro al consultarCursadas ');
		
		
		let carrera    : string = this.form.controls["carrera"].value,
			asignatura : string = this.form.controls["asignatura"].value,
			docente    : any    = this.form.controls["docente"].value,
			body       : string = "key=buscarCursada&carrera="+carrera+"&asignatura="+asignatura+"&docente="+docente,
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
    
    consultarMesa() 
	{
		 /* ---SE DEBE BORRAR --- */
		console.log(' Entro al consultarMesa ');
		
		
		let carrera    : string = this.form.controls["carrera"].value,
			asignatura : string = this.form.controls["asignatura"].value,
            docente    : string    = this.form.controls["docente"].value,
			body       : string = "key=buscarMesa&carrera="+carrera+"&asignatura="+asignatura+"&docente="+docente,
           	type       : string = "application/x-www-form-urlencoded; charset=UTF-8",
			headers    : any    = new Headers({ 'Content-Type': type}),
			options    : any    = new RequestOptions({ headers: headers }),
			url        : any    = this.baseURI + "tempus.php";
      
      if(carrera == null) {
      console.log('carrera nulaaa');
      }
      
      this.http.post(url, body, options)
      .subscribe(data =>
      {
       
		  /* ---SE DEBE BORRAR --- */
		  console.log(data.json());
		  
		  if(data.status === 200) {
			  /* ---SE DEBE BORRAR --- */
		
			  /* SE HA OBTENIDO RESULTADO. ASIGNA EL RESULTADO DE LA CONSULTA A LAS MESAS  */
			  this.mesasE = data.json();
			  
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
  
   //comprueba compos cuando oprime el boton
    compruebaCampos(){
     if(this.mesaCarrera){  
            }}

}

