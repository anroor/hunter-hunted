/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package hunterserversocket;

import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
 
import javax.sql.rowset.CachedRowSet;
import com.sun.rowset.CachedRowSetImpl;
import javax.sql.RowSet;

/**
 *
 * @author arortega
 */
public class Hunterserversocket {
  public static String sql;
  public static int cont;
  public static String url ;
  public static Connection conn;
  public static Statement s ;
  public static ResultSet rs;
  public static  CachedRowSetImpl rowset ;
    /**
     * @param args the command line arguments
     */
   public static void main(String[] args){
        int cont=0;
        ServerSocket serverSocket = null;
        Socket socket = null;
        DataInputStream dataInputStream = null;
        DataOutputStream dataOutputStream = null;

        try {
            serverSocket = new ServerSocket(8888);
            System.out.println("Listening :8888");
        } catch (IOException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
  
        while(true){
            try {
                socket = serverSocket.accept();
                dataInputStream = new DataInputStream(socket.getInputStream());
                dataOutputStream = new DataOutputStream(socket.getOutputStream());
                System.out.println("ip: " + socket.getInetAddress());
                String msj=dataInputStream.readUTF();
                System.out.println("message: " + msj);
                cont++;

                String codigo_msj = msj.substring(0, 1);


                //Si el mensaje es del tipo login 
                if(codigo_msj.equals("1")){ 
                    String []infouser= msj.split("&");   
                    try{
                        Class.forName("org.gjt.mm.mysql.Driver");

                        url = "jdbc:mysql://localhost/hunterhunted_bd";
                        conn = DriverManager.getConnection(url, "root","");
                        s = conn.createStatement(ResultSet.TYPE_SCROLL_SENSITIVE,
                                                          ResultSet.CONCUR_READ_ONLY);

                        sql="SELECT * FROM users WHERE user_name= '"+infouser[1]+"' and password = '"+infouser[2]+"';";
                        rs= s.executeQuery(sql);

                        if(rs.next()){
                            dataOutputStream.writeUTF("1");
                            sql="UPDATE users SET status = 1 WHERE user_name= '"+infouser[1]+"';";
                            if(!s.execute(sql)){
                              System.out.println("Actualizo el status");
                            }
                        }else{
                            dataOutputStream.writeUTF("0");
                        }
                        cerrar_conexion();

                        if (conn != null){
                             dataOutputStream.writeUTF("Conexión a base de datos "+url+" ... Ok");
                        }
                        conn.close();

                    }catch(Exception e){
                        dataOutputStream.writeUTF(e.getMessage());
                    }
                }

                // si el mensaje es de log out 
                if(codigo_msj.equals("2")){
                    String []infouser= msj.split("&");  
                    try{
                        Class.forName("org.gjt.mm.mysql.Driver");
                        conexion(); 

                        sql="SELECT * FROM users WHERE user_name= '"+infouser[1]+"';";
                        rs= s.executeQuery(sql);

                        if(rs.next()){
                            sql="UPDATE users SET status = 0 WHERE user_name= '"+infouser[1]+"';";
                            if(!s.execute(sql)){
                               dataOutputStream.writeUTF("1");
                               System.out.println("Actualizo el status desconectado");
                               sql="DELETE FROM users_match WHERE users_id ="+getid_user(infouser[1]) +";";
                               if(!s.execute(sql)){
                                   System.out.println("Actualizo la tabla users_matchs");
                               }
                            }else{
                            //dataOutputStream.writeUTF("No se desconecto");
                            }

                        }
                        cerrar_conexion();
                        if (conn != null){
                            dataOutputStream.writeUTF("Conexión a base de datos "+url+" ... Ok");
                        }
                        
                    }catch(Exception e){
                        dataOutputStream.writeUTF(e.getMessage());
                    }
                }

             //Mensaje para obtener de partida
             if(codigo_msj.equals("3")){
                try{
                    Class.forName("org.gjt.mm.mysql.Driver");
                    conexion();

                    sql="SELECT * FROM matchs;";
                    rs= s.executeQuery(sql);
                    rowset = new CachedRowSetImpl(); 
                    rowset.populate(rs);

                    String info_partida="";
                    while(rowset.next()){
                        info_partida+=rowset.getString("match_name")+"&"+get_no_jugadores(rowset.getString("match_name")) +"%";      
                    }
                    dataOutputStream.writeUTF(info_partida);
                   //ataOutputStream.writeUTF();
                    cerrar_conexion();
                }catch (Exception e) {
                    dataOutputStream.writeUTF(e.getMessage());
                }
             }
             
             //Mensaje para crear partida
             if(codigo_msj.equals("4")){
                 String info_match[] = msj.split("&");
                 try{
                     Class.forName("org.gjt.mm.mysql.Driver");
                     conexion();
                     sql="INSERT INTO matchs (match_name, id_creator) VALUES ('"+info_match[1]+"',"+getid_user(info_match[2])+") ;";

                     if(!s.execute(sql)){
                         dataOutputStream.writeUTF("1");
                        
                         
                            sql= "Insert into users_matchs(users_id,match_id) values("+getid_user(info_match[2]) +","+getid_match(info_match[1])+");";
                            if(!s.execute(sql)){
                                System.out.println("si registro en la tabla users_matchs");
                            }
                        
                     }
                     //ataOutputStream.writeUTF();
                     cerrar_conexion();
                 } catch (Exception e) {
                     dataOutputStream.writeUTF("0");
                 }
             }

             // mensaje de ingreso a una partida 
             if(codigo_msj.equals("5")){
                 String info_match[] = msj.split("&");
                 String salida ="";
                 try {
                     Class.forName("org.gjt.mm.mysql.Driver");
                     conexion();
                     sql= "Insert into users_matchs(users_id,match_id) values("+getid_user(info_match[2]) +","+getid_match(info_match[1])+");";

                     if(!s.execute(sql)){
                         System.out.println("si registro en la tabla users_matchs");
                        
                       
                             System.out.println("si Actualizo el numero de jugadores");
                             sql="SELECT * FROM users , users_matchs Where match_id ="+getid_match(info_match[1])+" and users.id =users_matchs.users_id ;";  
                             rs = s.executeQuery(sql);
                             while(rs.next()){
                                 salida+= rs.getString("user_name")+"&"; 
                             }
                             sql= "Select user_name as name from users, matchs where users.id = matchs.id_creator and matchs.match_name = '"+info_match[1]+"';";
                             rs=s.executeQuery(sql);    
                             while(rs.next()){
                                 salida+=rs.getString("name");
                             }
                             
                             salida="3"+salida;
                             System.out.println(salida);
                             dataOutputStream.writeUTF(salida);
                 
                             
                       
                     }else{System.out.println("No registro en la tabla users_matchs");}

                     //ataOutputStream.writeUTF();
                     cerrar_conexion();
                } catch (Exception e) {
                    dataOutputStream.writeUTF(e.getMessage());
                }
             }
             
         //mensaje de abandonar partida
              if(codigo_msj.equals("6")){
               String info_match[] = msj.split("&");


                 try {
                       Class.forName("org.gjt.mm.mysql.Driver");

                            conexion();

                              sql="DELETE FROM users_matchs WHERE users_id ="+getid_user(info_match[2]) +";";
                                if(!s.execute(sql)){
                                System.out.println("Actualizo la tabla users_matchs");
                                 dataOutputStream.writeUTF("1");
                                  
                                }else  {
                                    System.out.println("No registro en la tabla users_matchs");
                                }
                      //ataOutputStream.writeUTF();

                             cerrar_conexion();
                     } catch (Exception e) {

                    dataOutputStream.writeUTF(e.getMessage());

                 }

             }
              
          //mensaje para saber los roles de cada jugador
              if(codigo_msj.equals("7")){
               String info_match[] = msj.split("&");


                 try {
                       Class.forName("org.gjt.mm.mysql.Driver");

                            conexion();

                           sql="UPDATE users SET rol = 0 "
                                   + "FROM users_matchs, users "
                                   + "WHERE users_matchs.match_id = '"+getid_match(info_match[1]) +"' and users.id = users_matchs.users_id;";
                                if(!s.execute(sql)){
                                System.out.println("SE COLOCARON TODOS COMO PRESAS");
                                   sql="UPDATE users SET rol = 1 "
                                        + "WHERE users.id = "+getid_user(info_match[2]) +";";
                                    if(!s.execute(sql)){
                                    dataOutputStream.writeUTF("2");
                                    }else
                                    {
                                    System.out.println("No cambio nada");
                                    }
                                }else  {
                                    System.out.println("No registro en la tabla users_matchs");
                                }
                      //ataOutputStream.writeUTF();

                             cerrar_conexion();
                     } catch (Exception e) {

                    dataOutputStream.writeUTF(e.getMessage());

                 }

             } 

            } catch (IOException e) {
             // TODO Auto-generated catch block
             e.printStackTrace();
            }
            finally{
             if( socket!= null){
              try {
               socket.close();
              } catch (IOException e) {
               // TODO Auto-generated catch block
               e.printStackTrace();
              }
             }

             if( dataInputStream!= null){
              try {
               dataInputStream.close();
              } catch (IOException e) {
               // TODO Auto-generated catch block
               e.printStackTrace();
              }
             }

             if( dataOutputStream!= null){
              try {
               dataOutputStream.close();
              } catch (IOException e) {
               // TODO Auto-generated catch block
               e.printStackTrace();
              }
             }
            }
        }
 }
   
  public static void conexion(){
         try{          
          url = "jdbc:mysql://localhost/hunterhunted_bd";
                    conn = DriverManager.getConnection(url, "root","");
                    s = conn.createStatement(ResultSet.TYPE_SCROLL_SENSITIVE,
                  ResultSet.CONCUR_READ_ONLY);
         }catch(Exception e){
         }
      
  }
  public static void cerrar_conexion(){
     try { 
      rs.close();
      s.close();
      conn.close();
     rowset.close();
     }catch(Exception e ) {
      
      }
}
   public static String getid_user(String user_name){
                     sql="SELECT id  FROM users WHERE user_name = '"+user_name+"';";
                   String id_user ="";
                  try{
                     rs= s.executeQuery(sql);                     
                     if(rs.next()){
                     id_user= rs.getString("id");
                     }                   
                    
                  }catch(Exception e){
                       
                  }
                    return id_user;
   }
    public static String getid_match(String match_name){
                     sql="SELECT id  FROM matchs WHERE Match_name = '"+match_name+"';";
                   String id_match = "";
                  try{
                     rs= s.executeQuery(sql);                     
                  if(rs.next()){
                   id_match= rs.getString("id");
                  }
                  
                  }catch(Exception e){
                                    
                  }
                    return id_match;
   }
  public static String get_no_jugadores(String match_name){
              sql="SELECT count(*)as cuenta FROM users_matchs WHERE Match_id = "+getid_match(match_name) +";";
                   String no_jug= "";
                  try{
                     rs= s.executeQuery(sql);                     
                    if(rs.next()){
                    no_jug = rs.getString("cuenta");
                    }
                     
                  }catch(Exception e){
                    
                  }
                    return no_jug;
  }  
  
  public static String get_name_jugador(String id ){
  sql="SELECT user_name as name FROM users WHERE id = "+ id +";";
                   String name_jug= "";
                  try{
                     rs= s.executeQuery(sql);                     
                    if(rs.next()){
                    name_jug = rs.getString("name");
                    }
                     
                  }catch(Exception e){
                    
                  }
                    return name_jug;
  }
    
    
}
