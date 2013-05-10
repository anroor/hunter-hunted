package us.kendellfabrici.leeter;

import java.util.Random;
import java.util.Timer;
import java.util.TimerTask;

import us.kendellfabrici.leeter.com.LeetCommunicator;
import android.net.ConnectivityManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Intent;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;

public class MainMatchActivity extends Activity {
   String matchname,user;
   Boolean sw=false;int time=0;
   Button btrandom;
   TextView textError,textmatchname,textin;
   AlertDialog.Builder builder;
	ListView listView;
	 String [] contactos={"",""} ;
	 Boolean swconteo=true,swtimer=false,sw2=false,swroles=false;
	 Timer timer;
	 String rol="presa",cazador="";
	  
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main_match);
		 listView = (ListView) findViewById(R.id.listView1);  
		 builder = new AlertDialog.Builder(this);
		 btrandom = (Button)findViewById(R.id.btnRandom);
		  textin = (TextView)findViewById(R.id.textin);
		  textError = (TextView)findViewById(R.id.textError);
		  textmatchname= (TextView)findViewById(R.id.textmatchname);
		  	
	       Bundle bun = getIntent().getExtras();
	       user= bun.getString("nameuser");
	       matchname = bun.getString("namepartida");
		   textmatchname.setText("Partida: "+matchname);
		   btrandom.setVisibility(View.INVISIBLE);
		   
		   
	   	    
		   
			String input ="5&"+matchname+"&"+user;
		   new LeetCom().execute(input);
		   
		   
		   
		   TimerTask task = new TimerTask() {
	            public void run() {
	            if(swtimer==false){

	    			String input ="8&"+matchname;
	    	    	new LeetCom().execute(input);
	    	    	
	            }else
	            {
	            	timer.cancel();
	            }
	    	    	
	            }
	        };
	        
	        timer = new Timer();
	        timer.schedule(task, 3000, 3000);
	        
		   
		


	    	

		
	}
	
    public void	preguntar(){

    	
    	}
    
	 public void CargarJugadores(String jugadores) {
           contactos=jugadores.toString().split("&"); 	   
           ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
	       android.R.layout.simple_list_item_1, contactos);          
		   // Assign adapter to ListView
	       listView.setAdapter(adapter);	  
    }
	 
	 public void btnLeftMatch(View view) {
		 
		 String input ="6&"+matchname+"&"+user;
	    	new LeetCom().execute(input);
	
	}
	 
	 public void btnRandom(View view) {
		 if(sw!=true){
		 String cazador="";
	    int nextInt = new Random().nextInt(contactos.length);
	    for(int i=0;i<contactos.length;i++)
	    {if(i==nextInt){
	    	 cazador=contactos[i];
	    	 contactos[i]+="  Cazador";
	    	
	    }else
	    {
	    	 contactos[i]+="  Presa";
	    }
	    
	   
	    }
	    ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
	 	       android.R.layout.simple_list_item_1, contactos);          
	 		   // Assign adapter to ListView
	 	       listView.setAdapter(adapter);
	    
	 	       String input ="7&"+matchname+"&"+cazador;
		   	  new LeetCom().execute(input);
		    	sw=true;
		    	 btrandom.setText("Iniciar Juego");
		 }else
		 {
			
		  String input ="9&"+matchname;
		  new LeetCom().execute(input);
		  
		 }
	}
	 
	 
	 
 public void DejarPartida(){
    	 
         finish();
      	 Intent i = new Intent(this,MatchesAct.class);  
       	 i.putExtra("name",user);
  	     startActivity(i);
		 
	 }
 
 public void MostrarRoles(String cazador){
	if(swroles==false){
		
	 textin.setText(cazador);
    
	 for(int i=0;i<contactos.length;i++)
	    {if(contactos[i].contains(cazador)){
	    	
	    	 contactos[i]=contactos[i]+ "Cazador";
	    	
	    }else
	    {
	    	 contactos[i]=contactos[i]+"Presa";
	    }
	   
	    }
	 
	
	    ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
	 	       android.R.layout.simple_list_item_1, contactos);          
	 		   // Assign adapter to ListView
	 	       listView.setAdapter(adapter);
	 	  	swroles=true;
	}

 }
 
 public void iniciarconteo() { 
	 if(swtimer==true){
	 if(sw2==false){
	 Intent i = new Intent(this,BeginGame1.class); 
	 i.putExtra("nameuser",user);
	 i.putExtra("rol",cazador);
	 finish();
	 startActivity(i);
	 sw2=true;
	 }}
	     
 }

    /**
     * This is the AsyncTask class.
     * @author kendell
     *
     */
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
			String creator="";
	    //  textin.append(result);
			
			if(result.equals("1"))				   
			{  
				DejarPartida();	
				
			}
				
	     	if(result.equals("2")){
	     	//	 textin.setText("ok ya hay cazador");
					//ir al conteo regresivo
					
		     } 
	    	if(result.equals("5")){
	    		timer.cancel();
	    		swtimer=true;
	    		
	    		iniciarconteo();
	     
		     } 
	       	if(result.equals("Espere")){
	     	    textin.setText("Esperando anfitrion...");
					//ir al conteo regresivo	
		     } 
	       	
	        if(result.substring(0,1).equals("4") && creator!=user){
	     		
	     //	 textin.setText(result);
	     	  String cazador=result.substring(1,result.length());
	     	 if(cazador.contains(user))
	    	 {
	    		 rol="cazador";
	    	 }
	     	 
	     	   MostrarRoles(cazador);
	     	   
	    				
		    } 
				
			if(result.substring(0,1).equals("3")){
				
				 creator=result.toString().split("&")[result.toString().split("&").length-1]; 
			     textin.setText(creator+user);
				 if(creator.equals(user))
				   {
					btrandom.setVisibility(View.VISIBLE);
					textin.append("   entro");
				   }else
				   {
					//   preguntar();
					   
				   }  
					   
				 result=result.substring(1,result.length()-1-creator.length());
				 CargarJugadores(result);				
			}	
			    
	    }
    	
    
    
		}

}
    }