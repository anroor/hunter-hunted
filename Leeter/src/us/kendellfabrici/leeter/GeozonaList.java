package us.kendellfabrici.leeter;

import java.util.ArrayList;


public class GeozonaList {
	
	ArrayList<Geozona> Geozonas;

	
	public GeozonaList() {
	
		Geozonas =new ArrayList<Geozona>();
	}
	
	  public void addGeozona(String nombre, double posy, double posx,String tipo,String alias) {	  
	   Geozonas.add(new Geozona(nombre,posx,posy,tipo,alias));    
	
	  }
	  
	 public Geozona getGeozona(String nombre) {	  
		 for(Geozona g: Geozonas){
			 if(g.getNombre().equals(nombre))
			 {
				return g; 
				
			 }
			 
		 }
		 return null;
	 }
	 public String getNombreGeozona(String alias) {	  
		 for(Geozona g: Geozonas){
			 if(g.getAlias().equals(alias))
			 {
				return g.getNombre(); 
				
			 }
			 
		 }
		 return null;
	 }
	    
	 public double[] getCoordenadas(String alias) {
		 double[] coords={0,0};
		 for(Geozona g: Geozonas){
			 if(g.getAlias().equals(alias))
			 {  coords[0]=g.getCoordX();
			    coords[1]=g.getCoordY();
				 return coords; 
				
			 }
			 
		 }
		 return null;
	 }


	public String GetGeozona(double posY, double posX){
		String geozona="";double menordist=10e9;
		
		for(Geozona g: Geozonas){
			double dist=DistEuclidiana(posX, posY, g.getCoordX(), g.getCoordY());
			if(dist<menordist)
			{
				menordist=dist;			
				geozona=g.getNombre();
			}	
		
		}
		
		if(menordist>=3.689937e-4)
		{
			return "";
		}
		else
		{
			
			return geozona;
		}
					

	}
	
	 public double DistEuclidiana(double x1,double y1, double x2, double y2)
     {
     return Math.sqrt(Math.pow((x2-x1),2)+Math.pow((y2-y1),2));
     	       	     	
     }
	

}
