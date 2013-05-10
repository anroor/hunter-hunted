package us.kendellfabrici.leeter;

public class Geozona {
	String nombre;
	double  coordX;
	double  coordY;
	String tipo;
	String alias;
	
	public Geozona(String nombre, double coordX, double coordY, String tipo, String alias) {
		super();
		this.nombre = nombre;
		this.coordX = coordX;
		this.coordY = coordY;
		this.tipo=tipo;
		this.alias=alias;
	}

	public String getAlias() {
		return alias;
	}

	public void setAlias(String alias) {
		this.alias = alias;
	}

	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}

	public double getCoordX() {
		return coordX;
	}

	public void setCoordX(double coordX) {
		this.coordX = coordX;
	}

	public double getCoordY() {
		return coordY;
	}

	public void setCoordY(double coordY) {
		this.coordY = coordY;
	}

	public String getTipo() {
		return tipo;
	}

	public void setTipo(String tipo) {
		this.tipo = tipo;
	}
	
	
	
	
    

}
