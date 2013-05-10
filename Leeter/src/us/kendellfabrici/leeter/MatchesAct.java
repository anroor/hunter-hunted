package us.kendellfabrici.leeter;


import java.util.List;

import us.kendellfabrici.leeter.com.LeetCommunicator;
import android.media.AudioManager;
import android.media.MediaPlayer;
import android.media.SoundPool;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;

import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.AdapterView.OnItemClickListener;

public class MatchesAct extends Activity {
	TextView textwelcome;
	 AlertDialog.Builder builder;
	 ListView listView;
	 String [] contactos={"",""} ;
	String	user="";
	int pos=0, flujodemusica;
	SoundPool fx;
	MediaPlayer reproSonido;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_matches);
		builder = new AlertDialog.Builder(this);
		
	  reproSonido = MediaPlayer.create(MatchesAct.this, R.raw.menu); 
		reproSonido.start();
		
		fx = new SoundPool(8, AudioManager.STREAM_MUSIC, 0);
		this.setVolumeControlStream(AudioManager.STREAM_MUSIC);
		flujodemusica= fx.load(this,R.raw.select ,1);
		
		textwelcome = (TextView)findViewById(R.id.textwelcome);
		
		 listView = (ListView) findViewById(R.id.listView1);  
		 
		    Bundle bun = getIntent().getExtras();
			user = bun.getString("name");
			textwelcome.setText("Hola "+user);
			
			
			String input ="3";
	    	new LeetCom().execute(input);
	    	

			 listView.setOnItemClickListener(new OnItemClickListener( ) 
			 
     		 
			 {
			  public void onItemClick(AdapterView<?> parent, View view ,int posicion , long id){
				  fx.play(flujodemusica, 1, 1, 0, 0, 1);
				 pos = posicion;  
				
	 	          DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {	  	       
	  		  	        public void onClick(DialogInterface dialog, int which) {
	  		  	            switch (which){
	  		  	            case DialogInterface.BUTTON_POSITIVE: 
	  		  	            fx.play(flujodemusica, 1, 1, 0, 0, 1);
	  		  	                   textwelcome.append("si");
	  		  	                   CargarPartida(contactos[pos].split("&")[0].toString());
	  		  	                   break;
	  		  	            case DialogInterface.BUTTON_NEGATIVE:
	  		  	            fx.play(flujodemusica, 1, 1, 0, 0, 1);
	  		  	               textwelcome.append("no"); 
	  		  	               break;
	  		  	           
	  		  	            }
	  		  	        }
	  		  	    };
	  		  	    
	 builder.setMessage("Deseas ir a la partida "+contactos[pos]+" ?").setPositiveButton("Si", dialogClickListener)
	  		        .setNegativeButton("No", dialogClickListener).show();
				
	               //    Bundle bun = getIntent().getExtras();
				//	    intent = new Intent(cma,MessageMainActivity.class);
					//    String [] UserB = contactos[pos].split("&");
				//		intent.putExtra("usuarios", bun.getString("name")+","+UserB[0].toString());
				     
				//		startActivity(intent);
				
			  }
			 });
			 
			 
			 
				 
	}
	
	 public void CargarPartidas(String partidas) {

		
		 	contactos=partidas.toString().split("%");
			final List<MyStringPair> myStringPairList = MyStringPair.makeData(contactos);
		    MyStringPairAdapter adapter = new MyStringPairAdapter(this, myStringPairList);
		              
		    listView.setAdapter(adapter);
		  
	}
	 
	 public void btnCreateMatch(View view) {
		 
		 fx.play(flujodemusica, 1, 1, 0, 0, 1);
	     Intent i = new Intent(this,CreateMatchActivity.class);
	   	 i.putExtra("name",user);
	   	 finish();
	   	 startActivity(i);
		 
	}
	   @Override
		protected void onResume() {
			// TODO Auto-generated method stub
			super.onResume();
			reproSonido.start();
		}

		@Override
		protected void onStop() {
			// TODO Auto-generated method stub
			super.onStop();
			reproSonido.stop();
		}
	 
	 public void CargarPartida(String NombrePart) {
		 
	     Intent i = new Intent(this,MainMatchActivity.class);
	   	 i.putExtra("nameuser",user);
	   	 i.putExtra("namepartida",NombrePart);
	   	 finish();
	   	 startActivity(i);
	
	}
	 
	 
	 public void btnLogout(View view) {
		 fx.play(flujodemusica, 1, 1, 0, 0, 1);
		 	String input ="2&"+user;
	    	new LeetCom().execute(input);
	
	}
	 public void CerrarSesion(){
		
         finish();
	     Intent intent = new Intent(this,LeeterActivity.class);
	     startActivity(intent);
		 
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
			
	
			if(result.equals("1"))				   
			{ CerrarSesion();	
			}else{
			   CargarPartidas(result);			
			}
			
		  
		    
	    }
    	
    }

}
