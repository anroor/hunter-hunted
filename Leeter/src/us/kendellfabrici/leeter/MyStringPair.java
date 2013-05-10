package us.kendellfabrici.leeter;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class MyStringPair {
	private String columnOne;
    private String columnTwo;
    
    public MyStringPair(String columnOne, String columnTwo) {
        super();
        this.columnOne = columnOne;
        this.columnTwo = columnTwo;
    }
    
    public String getColumnOne() {
        return columnOne;
    }
    public void setColumnOne(String columnOne) {
        this.columnOne = columnOne;
    }
    public String getColumnTwo() {
        return columnTwo;
    }
    public void setColumnTwo(String columnTwo) {
        this.columnTwo = columnTwo;
    }
    
    public static List<MyStringPair> makeData(String[] array) {
        List<MyStringPair> pair = new ArrayList<MyStringPair>();
        String[] partida = {"",""};
        for (int i=0;i<array.length; i++) {
        	partida = array[i].toString().split("&");
        	//pair.add(new MyStringPair(array[i], Integer.toString(i+1)));
        	pair.add(new MyStringPair(partida[0], partida[1]));        	
        }
        return pair;
    }
}
