package us.kendellfabrici.leeter;

import com.google.android.maps.MapActivity;

import us.kendellfabrici.leeter.com.LeetCommunicator;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.ColorFilter;
import android.graphics.Matrix;
import android.graphics.Paint;
import android.graphics.Paint.Style;
import android.graphics.PorterDuff.Mode;
import android.graphics.Typeface;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnTouchListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class MapGame extends Activity implements LocationListener,OnTouchListener {
	 private GeozonaList geozonas= new GeozonaList();
	private TextView ubicuniv,puntaje,conteo;
	private EditText txtlat, txtlon, edt_cazar;
	private Button button,button2,	btn_ManualLoc,btn_Info,btn_Route,btn_cazar;
	private float lati=0;
	private  RelativeLayout layout1;
	private  LinearLayout mlayout;
	Lienzo fondo; 
	private LocationManager manager;
	private boolean running;
	private boolean networkEnabled;
	private boolean gpsEnabled;
	 private int corx=0, cory=0,swmode=0,corx2,cory2;
     double puntox=0,lat,lon,lonc=-74.850342,latc=11.018052,lonr2=0;
     double puntoy=0;
	 String ruta="",origenant="s",	user=" ",rol=" ";
	 String origen="",info_lug2,cazador=" ";
	 int time=300;
	 double 	puntoxi,puntoyi;
		String destino="",info_lug="";
		int sw2=0,swroute=0,swinfo=0;
	 AlertDialog.Builder builder;
	
		@Override
	public void onBackPressed() {
		// TODO Auto-generated method stub
		super.onBackPressed();
		
	
    	this.finish();
	}


		 Handler updateHandler;
		 Location currentBestLocation=null;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_map_game);
		  builder = new AlertDialog.Builder(this);
		  edt_cazar= (EditText) findViewById(R.id.Edt_Cazar);
	
        layout1 = (RelativeLayout) findViewById(R.id.layout1);
        mlayout = (LinearLayout) findViewById(R.id.mlayout);
        
        button=(Button)findViewById(R.id.button);
        btn_cazar=(Button)findViewById(R.id.btn_Cazar);
        
        btn_cazar.setVisibility(View.INVISIBLE);
        edt_cazar.setVisibility(View.INVISIBLE);
        edt_cazar.setVisibility(View.GONE);
        mlayout.setBackgroundColor(Color.BLACK);
        fondo = new Lienzo(this);
        layout1.addView(fondo);
        
        geozonas.addGeozona("Biblioteca", 11.018052, -74.850342,"cruce","BL"); 
        geozonas.addGeozona("Biblioteca", 11.017894,-74.85025,"centro","BL"); 
                        
        geozonas.addGeozona("Bloque A",11.018389,-74.851007,"cruce","A");
        geozonas.addGeozona("Bloque A",11.018497,-74.851187,"centro","A");    
        
        geozonas.addGeozona("Bloque B",11.018697,-74.850921,"cruce","B");
        geozonas.addGeozona("Bloque B",11.018776,-74.851098,"centro","B");
     
        geozonas.addGeozona("Bloque C",11.018942,-74.850841,"cruce","C");
        geozonas.addGeozona("Bloque C",11.019008,-74.851036,"centro","C");  
        
        geozonas.addGeozona("Bloque D",11.0182,-74.850328,"cruce","D");
        geozonas.addGeozona("Bloque D",11.018184,-74.850073,"centro","D");
        
        geozonas.addGeozona("Bloque E",11.018495,-74.850205,"cruce","E");
        geozonas.addGeozona("Bloque E",11.018471,-74.850004,"centro","E");  
     
        geozonas.addGeozona("Bloque F",11.018734,-74.850141,"cruce","F");
        geozonas.addGeozona("Bloque F",11.018726,-74.849942,"centro","F");  
        
        geozonas.addGeozona("Lab 1",11.018302,-74.850674,"cruce","L1");
        geozonas.addGeozona("Lab 1",11.018445,-74.850634,"centro","L1");
        
        geozonas.addGeozona("Lab 2",11.01861,-74.850548,"cruce","L2");
        geozonas.addGeozona("Lab 2",11.018742,-74.850529,"centro","L2");
        
        geozonas.addGeozona("Lab 3",11.018834,-74.85047,"cruce","L3");
        geozonas.addGeozona("Lab 3",11.018976,-74.850465,"centro","L3");
	

		ubicuniv= (TextView)findViewById(R.id.etubicuniv);
		puntaje= (TextView)findViewById(R.id.puntaje);
	
				
		
		manager=(LocationManager)getSystemService(Context.LOCATION_SERVICE);
		networkEnabled=manager.isProviderEnabled(LocationManager.NETWORK_PROVIDER);
		gpsEnabled=manager.isProviderEnabled(LocationManager.GPS_PROVIDER);
		running=false;
		

	

 	    
		if(!networkEnabled){
			
		 AlertDialog dialog= new AlertDialog.Builder(this).create();
		 dialog.setTitle("No hay Proveedor");
		 dialog.setMessage("Proveedor WFI no disponible");
		 dialog.setCancelable(true);
		 dialog.show();
		}
		if(!gpsEnabled){
			
			 AlertDialog dialog= new AlertDialog.Builder(this).create();
			 dialog.setTitle("No hay Proveedor");
			 dialog.setMessage("Proveedor GPS no disponible");
			 dialog.setCancelable(true);
			 dialog.show();
			}
		
		
		 Bundle bun = getIntent().getExtras();
	       user= bun.getString("nameuser");  
	 	
		String input ="11&";
    	new LeetCom().execute(input);
		
        
        updateHandler = new Handler();
          // Do this first after 1 second
          updateHandler.postDelayed(RecurringTask, 1000);
          
	if(!running){
			
			manager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER,0,0,this);
			manager.requestLocationUpdates(LocationManager.GPS_PROVIDER,0,0,this);
			running=true;
			
			
		}
		else
		{manager.removeUpdates(this);
		running=false;
		button.setText("Ubícame");
		
			
		
			
		}
    	
	}

    Runnable RecurringTask = new Runnable() {
        public void run() {
          // Do whatever you want
            fondo.invalidate();
            time-=1;
            if(time==0)
            	
            {       	
               findejuego();
            	
            }	
          // Call this method again every 30 seconds
          updateHandler.postDelayed(this,1000);
        }
      };
      
      public void findejuego() { 
    		 Intent i = new Intent(this,GameOverAct.class);  
    		 finish();
    		 startActivity(i);
    	 }
	
      


public void buttonPressed(View view) {
		
	    fondo.invalidate();
	    
	
		}

public void Cazar(View view) {
	
   
	      AlertDialog dialog= new AlertDialog.Builder(this).create();
		 dialog.setTitle("Ubicacion");
		 dialog.setMessage("Seleccione el lugar donde se encuentre ");
		 dialog.setCancelable(true);
		 dialog.show();	
			corx=0; cory=0;	
			swmode=1;
		 	fondo.setOnTouchListener(this);
		 
	}



	public void onLocationChanged(Location location) {
	
		   fondo.invalidate();  
		if(currentBestLocation==null)
		{
			currentBestLocation=location;
		}
		    int accuracyDelta = (int) (location.getAccuracy() - currentBestLocation.getAccuracy());
		    long timeDelta = location.getTime() - currentBestLocation.getTime();	    
		    boolean isLessAccurate = accuracyDelta > 0;
		
		    
		    if (isLessAccurate && timeDelta<4000) {
		       location=currentBestLocation;
		    } else{		    	
		    	currentBestLocation=location;
		    }
		    	
	    		lat=location.getLatitude();
	    	
	    		lon=location.getLongitude();
	    		
	
	    		
	    		   fondo.invalidate();
	    		   
	    	          String input ="10&"+user+"&"+lat+"&"+lon;
	    			   new LeetCom().execute(input);
	    			   
	    		    	
	    		    	if(cazador.equals(user)){
	    		    	  	
	    		    	   input ="12&";
	    					   new LeetCom().execute(input);
	    					   
	    		    		
	    		    	}else
	    		    	{
	    		    		
	    		    	   	    input ="13&";
	    		    				   new LeetCom().execute(input);
	    		    		
	    		    		
	    		    		
	    		    	}
	    			   
	    	
	    	
	}


	public void onProviderDisabled(String provider) {
		// TODO Auto-generated method stub

	}


	public void onProviderEnabled(String provider) {
		// TODO Auto-generated method stub
		
	}


	public void onStatusChanged(String provider, int status, Bundle extras) {
		// TODO Auto-generated method stub
	
		
	}
	

    public void perdio(){
    	
    	   String input ="2&user";
		   new LeetCom().execute(input);
		   finish();
		   Intent i=new Intent(this,GameOverAct.class);
		   startActivity(i);
		   
    		
    }
		
	
    public void jugar(){
    	
    	if(cazador.trim().equals(user.trim())){
    	  	
    	   String input ="12&";
			   new LeetCom().execute(input);
		   
    		
    	}else
    	{
    		
    	   	   String input ="13&";
    				   new LeetCom().execute(input);
    		
    		
    		
    	}
    	
    }
	
	
	
	class Lienzo extends View {

        public Lienzo(Context context) {
            super(context);
        }
  
        public Bitmap resizeImage(Bitmap image, int maxWidth, int maxHeight) {
            Bitmap resizedImage = null;
            try {
                int imageHeight = image.getHeight();

                if (imageHeight > maxHeight)
                    imageHeight = maxHeight;
                int imageWidth = (imageHeight * image.getWidth())
                        / image.getHeight();

                if (imageWidth > maxWidth) {
                    imageWidth = maxWidth;
                    imageHeight = (imageWidth * image.getHeight())
                            / image.getWidth();
                }

                if (imageHeight > maxHeight)
                    imageHeight = maxHeight;
                if (imageWidth > maxWidth)
                    imageWidth = maxWidth;

                resizedImage = Bitmap.createScaledBitmap(image, imageWidth,
                        imageHeight, true);
            } catch (OutOfMemoryError e) {

                e.printStackTrace();
            } catch (NullPointerException e) {
                e.printStackTrace();
            } catch (Exception e) {
                e.printStackTrace();
            }
            return resizedImage;
        }      
        
        public Bitmap resizeImage(int w, int h) { 

        	// load the origial Bitmap 
            Bitmap BitmapOrg = BitmapFactory.decodeResource(getResources(),
                    R.drawable.mapau);

        	int width = BitmapOrg.getWidth(); 
        	int height = BitmapOrg.getHeight(); 
        	int newWidth = w; 
        	int newHeight = h; 

        	// calculate the scale 
        	float scaleWidth = ((float) newWidth) / width; 
        	float scaleHeight = ((float) newHeight) / height; 

        	// create a matrix for the manipulation 
        	Matrix matrix = new Matrix(); 
        	// resize the Bitmap 
        	matrix.postScale(scaleWidth, scaleHeight); 
        	// if you want to rotate the Bitmap 
        	// matrix.postRotate(45); 

        	// recreate the new Bitmap 
        	Bitmap resizedBitmap = Bitmap.createBitmap(BitmapOrg, 0, 0, 
        	width, height, matrix, true); 

        	// make a Drawable from Bitmap to allow to set the Bitmap 
        	// to the ImageView, ImageButton or what ever 
        	return resizedBitmap; 

        	} 
  
        
        protected void onDraw(Canvas canvas) {
         
        
            Bitmap hunter= BitmapFactory.decodeResource(getResources(),
                    R.drawable.hunter);
            
            Bitmap presa= BitmapFactory.decodeResource(getResources(),
                    R.drawable.deer);
            
            
        	 // Escalar mapa al tamaño del Layout Y pintarla
        //    Bitmap bmp = resizeImage(BitmapOrg,canvas.getWidth(), canvas.getHeight());   
            Bitmap bmp = resizeImage(canvas.getWidth(), canvas.getHeight()-450);  
            canvas.drawBitmap(bmp,0,0 ,null);
            // Inicializar pincel
            Paint pincel1 = new Paint();
        	
                
            // Establecer medidas iniciales
            float ancho = canvas.getWidth();
            float alto = canvas.getHeight()-450;
            double cord0x=-748518540;
            double cord0y=110206170;
            double cordfx=-748493648.171455;
            double cordfy=110177363.690743;
            
            pincel1.setARGB(255, 200, 0, 0);
            pincel1.setStrokeWidth(25 );                   
          
        //   canvas.drawPoint(ancho/2, alto/2, pincel1);
           
            pincel1.setStrokeWidth(15 );     
            pincel1.setTextSize(50);
            canvas.drawText("Tiempo restante: "+String.valueOf(time), 10, alto+55, pincel1); 
           
            
           puntox=(lon*10e6-cord0x)*(ancho/(cordfx-cord0x));          
           puntoy=(lat*10e6-cord0y)*(alto/(cordfy-cord0y)); 
           
             
           canvas.drawBitmap(hunter,(int)puntox,(int)puntoy,pincel1); 
          
          if(!cazador.equals(user)){
        	  
        	  pincel1.setARGB(255, 120, 245, 0);
              puntox=(lonc*10e6-cord0x)*(ancho/(cordfx-cord0x));          
              puntoy=(latc*10e6-cord0y)*(alto/(cordfy-cord0y));              
         //    canvas.drawPoint((int)puntox,(int)puntoy,pincel1); 
             canvas.drawBitmap(presa,(int)puntox,(int)puntoy,pincel1); 
             edt_cazar.setVisibility(View.INVISIBLE);
        	  
          }else
          {
              btn_cazar.setVisibility(View.VISIBLE);
	            edt_cazar.setVisibility(View.VISIBLE);
          }
       if(swmode==1){
    	   
   		 String  origen=""+corx;
      	// Ubicacion  manual
          pincel1.setARGB(255, 0, 0, 255);            	  	        
          canvas.drawCircle(corx, cory, 10, pincel1); 	         
          double lonr=(cord0x+(corx/(ancho/(cordfx-cord0x))))/10e6;
          double latr=(cord0y+(cory/(alto/(cordfy-cord0y))))/10e6;   
                
       
        
          if (!edt_cazar.getText().equals("") && latr<11.020616 && latr>11.0177953 && lonr!=lonr2){
        	   String input ="14&"+edt_cazar.getText()+"&"+lonr+"&"+latr;
        	  new LeetCom().execute(input);
        	  lonr2=lonr;
          	}           
          }
	
	}

	}
	








	public boolean onTouch(View v, MotionEvent event) {
		// TODO Auto-generated method stub

        corx = (int) event.getX();
        cory = (int) event.getY();
        fondo.invalidate();    
        return true;
		
	}
	
	
	 private class LeetCom extends AsyncTask<String, Void, String> {
	    	
	    	/**
	    	 * The function that is run once the asynctask is kicked off.
	    	 */
			@Override
			protected String doInBackground(String... input) {
				//The LeetCommunicator is where the socket communication happens.
				LeetCommunicator com = new LeetCommunicator();
				return com.sendMessage(input[0]);
			}

					
			/**
			 * The AsyncTask callback which handles marshalling the result to the main GUI thread.
			 */
			protected void onPostExecute(String result) {
			
				if(result!=null){
			
					 ubicuniv.setText(result);
					 
		        if(result.substring(0,2).equals("CA")){
		        	
		     		cazador=result.substring(2,result.length());
		            ubicuniv.setText("Hola "+user+", el cazador del juego es "+result.substring(2,result.length()) );
		            jugar();	
		            
		    }
		        if(result.substring(0,2).equals("DI")){
		        	
			     		
			            ubicuniv.setText("Presa más cercana en: " +result.substring(2,5) );
			            puntaje.setText("Puntaje: "+result.split("&")[1]); 
										    
			    }
		        
		        
		        if(result.substring(0,2).equals("PR")){
		        	      
		              result=result.substring(2,result.length());
			          String []s=result.split(",");
		 
			        lonc=Double.valueOf(s[0])/100000;
			         latc=Double.valueOf(s[1])/100000;
			          ubicuniv.setText("Ubicación Cazador:"+geozonas.GetGeozona(latc,lonc)  );	
			          puntaje.setText("");  
		        }
		        
             if(result.substring(0,3).equals("hit")){
            	 if(!cazador.equals(user) && user.equals(result.substring(4,result.length())))
            	 { perdio();
		     	
            	 }
            	 if(cazador.equals(user))
            	 {  ubicuniv.setText("Felicitaciones, Acertaste!");
		     	   
            	 }
		     }
             if(result.substring(0,4).equals("miss")){
            	 if(cazador.equals(user) )
            	 { 
		     	  ubicuniv.setText("Fallaste, Has sido penalizado.");
            	 }
		     }
		        
		        
				}
	    	
	    
	    
			}
	 }

	
}


