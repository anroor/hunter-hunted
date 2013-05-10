package us.kendellfabrici.leeter;

import us.kendellfabrici.leeter.com.LeetCommunicator;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;

public class CreateMatchActivity extends Activity {
	
	EditText et_matchname;
    TextView textSuccessfull, textError;
    Spinner match_time;
    String user="";
    String match="";
    
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_create_match);
		textSuccessfull = (TextView)findViewById(R.id.textSuccessful);
		textError = (TextView)findViewById(R.id.textError);
		et_matchname = (EditText)findViewById(R.id.et_matchname);
		
       Bundle bun = getIntent().getExtras();
	    user = bun.getString("name");
	
	  //Spinner time_match
	    match_time = (Spinner)findViewById(R.id.s_matchTime);
	    ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(this,R.array.match_time,android.R.layout.simple_spinner_item);
	    adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
	    match_time.setAdapter(adapter);
		
	}
	
	 public void CargarPartida() {
		 
	     Intent i = new Intent(this,MainMatchActivity.class);
	   	 i.putExtra("nameuser",user);
	   	 i.putExtra("namepartida",et_matchname.getText());
	   	 finish();
	   	 startActivity(i);
	
	}
	 

	 public void btnCreateMatch(View view) {
		 
		 	String input ="4&"+et_matchname.getText()+"&"+user;
	    	new LeetCom().execute(input);
	
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
				
		
				if(result.equals("1"))				   
				{ 
					textSuccessfull.setVisibility(View.VISIBLE);
					CargarPartida();
				}else{
					textError.setVisibility(View.VISIBLE); 	
				}
				
				
			  
			    
		    }
	    	
	    }



}
