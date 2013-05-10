package us.kendellfabrici.leeter;



import us.kendellfabrici.leeter.com.LeetCommunicator;

import android.app.Activity;
import android.content.Intent;
import android.media.AudioManager;
import android.media.MediaPlayer;
import android.media.SoundPool;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

public class LeeterActivity extends Activity {
	
	EditText et_username,et_password;
	TextView textError;
	SoundPool fx;
	int flujodemusica;
	  MediaPlayer reproSonido;
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
        
       reproSonido= MediaPlayer.create(LeeterActivity.this, R.raw.menu); 
		reproSonido.start();
		
		fx = new SoundPool(8, AudioManager.STREAM_MUSIC, 0);
		this.setVolumeControlStream(AudioManager.STREAM_MUSIC);
		flujodemusica= fx.load(this,R.raw.select ,1);
        
        et_username = (EditText)findViewById(R.id.et_username);
        et_password = (EditText)findViewById(R.id.et_password);
        textError = (TextView)findViewById(R.id.textError);
    }
    
    /**
     * This is the button click event, which kicks of the translation.
     * @param v
     */
    public void btnLogin(View v) {
    	fx.play(flujodemusica, 1, 1, 0, 0, 1);
    	String input ="1&"+et_username.getText().toString()+"&"+et_password.getText().toString();
    	new LeetCom().execute(input);
    	
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

	public void iniciarsesion() { 
  	 Intent i = new Intent(this,MatchesAct.class);  
   	 i.putExtra("name",et_username.getText().toString());
   	 finish();
   	 startActivity(i);
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
					
		    if(result.equals("1")){
		    	iniciarsesion();		    		
		    }else{
		    	//prueba();
		    	textError.setVisibility(View.VISIBLE);	    
		    }
		    
	    }
    	
    }
    
    
}