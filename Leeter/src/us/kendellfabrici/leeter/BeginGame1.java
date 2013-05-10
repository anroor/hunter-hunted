package us.kendellfabrici.leeter;

import java.util.Timer;
import java.util.TimerTask;



import android.os.Bundle;
import android.os.Handler;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.Paint.Align;
import android.view.Menu;
import android.view.View;
import android.widget.Filter;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class BeginGame1 extends Activity {
	TextView txtconteo;int time=20;
	int cont=0;
	private  RelativeLayout layout1;
	Lienzo fondo;
	 Handler updateHandler;
	 String user,rol;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_begin_game1);
		
		
		
		 Bundle bun = getIntent().getExtras();
	     user= bun.getString("nameuser");
	     rol= bun.getString("rol"); 
	   	
	   	layout1 = (RelativeLayout) findViewById(R.id.layout1);	
	    fondo = new Lienzo(this);
        layout1.addView(fondo);
        fondo.invalidate();
		   
	
     
        updateHandler = new Handler();
          // Do this first after 1 second
          updateHandler.postDelayed(RecurringTask, 1000);
        
	        
	}
	
	
	
    Runnable RecurringTask = new Runnable() {
        public void run() {
          // Do whatever you want
            fondo.invalidate();
            time-=1;
            if(time==0)
            	
            {       	
               iniciarmapa();
            	
            }	
          // Call this method again every 30 seconds
          updateHandler.postDelayed(this,200);
        }
      };
      
      public void iniciarmapa() { 
    		 Intent i = new Intent(this,MapGame.class);  
    		 i.putExtra("nameuser",user);
    		 i.putExtra("rol",rol);
    		 finish();
    		 startActivity(i);
    	 }
	
	class Lienzo extends View {

        public Lienzo(Context context) {
            super(context);
        }
	 protected void onDraw(Canvas canvas) {
            
         Paint pincel1 = new Paint();
         pincel1.setARGB(255, 200, 0, 0);
     
         pincel1.setStrokeWidth(15 );     
         pincel1.setTextSize(600);
         pincel1.setTextAlign(Align.CENTER);
         // Establecer medidas iniciales
         float ancho = canvas.getWidth();
         float alto = canvas.getHeight();
                  
         canvas.drawText(String.valueOf(time), ancho/2, alto/2, pincel1); 
         pincel1.setTextSize(60);
         canvas.drawText(rol,100,100,pincel1); 
         }

	}

}
