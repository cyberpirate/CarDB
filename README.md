CarDB
=====

Tables
=====
Customer (*C_ID, C_Name, C_Address, C_Phone)
Employee (*E_ID, E_Name, E_Phone)
Make(*M_ID, M_Make, M_Model, M_Year)
Car (*Car_ID, M_ID)
Sale (*S_ID, *Car_ID, *C_ID, *E_ID, Price, Date)
Service_Appt(*A_ID, *C_ID, *Car_ID, *E_ID, Date_In, Date_Out)
Services_Done(*A_ID, *Serv_ID)
Service (*Serv_ID, Cost, Description)


get.php
=====

get data from the sql table

sample post:
/get.php?table=Customer&C_Address=nowhere

sample response:
[{"C_ID":"44","C_Name":"joe","C_Address":"nowhere","C_Phone":"666"},{"C_ID":"45","C_Name":"adam","C_Address":"nowhere","C_Phone":"777"}]

below are all the tables and columns that can be used, at least one table and one column must be in the request.
Customer (C_ID, C_Name, C_Address, C_Phone)
Employee (E_ID, E_Name, E_Phone)
Make(M_ID, M_Make, M_Model, M_Year)
Car (Car_ID, M_ID)
Sale (S_ID, Car_ID, C_ID, E_ID, Price, Date)
Service_Appt(A_ID, C_ID, Car_ID, E_ID, Date_In, Date_Out)
Services_Done(A_ID, Serv_ID)
Service (Serv_ID, Cost, Description)


add.php
=====

Insert data to the sql table. It returns a positive id if the insert worked. The id is the auto_increment key for the inserted data where it applies.

NOTE: For the date datatypes to enter data the date MUST be in YYYYMMDD format, otherwise the column will default to 0000-00-00. The date colums are Date in Sale, and Date_In/Date_Out in Service_Appt

sample post:
/add.php?table=Customer&C_Name=Harold&C_Address=nowhere&C_Phone=000

sample response:
{"id":46}

Here are all the tables and columns. All columns are REQUIRED for their respective table.
Customer (C_Name, C_Address, C_Phone)
Employee (E_Name, E_Phone)
Make (M_Make, M_Model, M_Year)
Car (M_ID)
Sale (Car_ID, C_ID, E_ID, Price, Date)
Service_Appt (C_ID, Car_ID, E_ID, Date_In, Date_Out)
Services_Done (A_ID, Serv_ID)
Service (Cost, Description)
