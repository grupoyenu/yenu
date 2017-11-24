import { Component } from '@angular/core'; //Para usar componenetes de Angular
import { IonicPage, NavController, NavParams, ToastController } from 'ionic-angular'; //NavController para navegar en distintas paginas
import { FormGroup, Validators, FormBuilder } from '@angular/forms';
import { Http, Headers, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/map';

@IonicPage()
@Component({
  selector: 'page-cursada', //es el selector css que va a aplicar a la pag
  templateUrl: 'cursada.html', //es la plantilla html que va a renderizar la pag
})
//exportamos la clase para luego poder importarla
export class CursadaPage {
	
	public form : FormGroup;
    //Define variables de cursada.htlm
	public cursadaCarrera : any;
	public cursadaAsignatura: any;
	public cursadaAnio : any;
	public cursadas : any = [];
    public carreras : any = [];
    public asignaturas : any = [];
	
	// IDENTIFICADORES PARA LA CARRERA Y ASIGNATURA
	public idasignatura : any = null;
	public idcarrera : any = null;
	
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
         "asignatura"           : [""],
		 "anio"           : [""]
      });
		
	}

	ionViewDidLoad() {
		console.log('ionViewDidLoad CursadaPage');
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
	consultarCursadas() 
	{
		 /* ---SE DEBE BORRAR --- */
		console.log(' Entro al consultarCursadas ');		
		
        
        let asignatura    : string = this.form.controls["asignatura"].value,
                    anio          : any = this.form.controls["anio"].value;
                
        if((asignatura==null) && (anio==null)) {
            this.enviarNotificacion("Debe indicar nombre de asignatura o año");
        } else {
        
             if(this.form.valid) {
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
                      console.log(" hace el request ");     
                      console.log(data.json());

                      if(data.status === 200) {
                                       console.log(" hay response ");         


                          /* SE HA OBTENIDO RESULTADO. ASIGNA EL RESULTADO DE LA CONSULTA A LAS CURSADAS  */
                          this.cursadas = data.json();
                          this.asignaturas = data.json();

                      } else {
                          this.enviarNotificacion("No se pudo procesar la petición");
                      }
                  });

            } else {

                this.enviarNotificacion("estoy tomando algo invalido");

                let carrera    : string = this.form.controls["carrera"].value;
                if (carrera == null) {
                    this.enviarNotificacion("Seleccione una carrera");
                } else {

                }
            }
        
        }
                
        
       
        
		
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
     if(this.cursadaCarrera){  
            }}

}

