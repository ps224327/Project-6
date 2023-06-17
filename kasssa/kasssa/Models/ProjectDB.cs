using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Configuration;     // Click de System.Configuration aan in References
using System.Data;

namespace kasssa.Models
{
    public class ProjectDB
    {
        private MySqlConnection _conn = new MySqlConnection(ConfigurationManager.ConnectionStrings["Project6"].ConnectionString);


        public List<Product> GetProductDetails()
        {
            List<Product> productResult = new List<Product>();

            try
            {
                _conn.Open();
                MySqlCommand cmd = _conn.CreateCommand();

                cmd.CommandText = "SELECT id, name, barcode, description, price, stock, color, height_cm, width_cm, depth_cm, weight_gr FROM products";

                MySqlDataReader reader = cmd.ExecuteReader();
                DataTable dt = new DataTable();
                dt.Load(reader);
                foreach (DataRow row in dt.Rows)
                {
                    Product productdetails = new Product();
                    
                    productdetails.Id = (int)row["Id"];
                    productdetails.Name = (string)row["Name"];
                    productdetails.Barcode = (string)row["Barcode"];
                    productdetails.Description = (string)row["Description"];
                    productdetails.Price = (string)row["Price"];
                    productdetails.Stock = (string)row["Stock"];
                    productdetails.Color = (string)row["Color"];
                    productdetails.Height_cm = (string)row["Height_cm"];
                    productdetails.Width_cm = (string)row["Widht_cm"];
                    productdetails.Depth_cm = (string)row["Depth_cm"];
                    productdetails.Weight_gr = (string)row["Weight_gr"];

                    Console.ReadLine();
                    productResult.Add(productdetails);
                }
            }
            catch (Exception)
            {

                Console.Error.WriteLine("error");
            }
            finally
            {
                _conn.Close();
            }
            return productResult;
        }

        public List<Users> GetUserDetails()
        {
            List<Users> UserResult = new List<Users>();

            try
            {
                _conn.Open();
                MySqlCommand cmd = _conn.CreateCommand();
                cmd.CommandText = "SELECT id, name, email, password, employee_number, role FROM users";

                MySqlDataReader reader = cmd.ExecuteReader();
                DataTable dt = new DataTable();
                dt.Load(reader);
                foreach (DataRow row in dt.Rows)
                {
                    Users UserDetails = new Users();

                    UserDetails.Id = Convert.ToUInt64(row["id"]);

                    if (row["name"] != DBNull.Value)
                        UserDetails.Name = Convert.ToString(row["name"]);
                    else
                        UserDetails.Name = ""; // or null, depending on your preference

                    if (row["email"] != DBNull.Value)
                        UserDetails.Email = Convert.ToString(row["email"]);
                    else
                        UserDetails.Email = ""; // or null

                    if (row["password"] != DBNull.Value)
                        UserDetails.Password = Convert.ToString(row["password"]);
                    else
                        UserDetails.Password = ""; // or null

                    if (row["employee_number"] != DBNull.Value)
                        UserDetails.Employee_number = Convert.ToInt32(row["employee_number"]);
                    else
                        UserDetails.Employee_number = 0; // or any other default value

                    if (row["role"] != DBNull.Value)
                        UserDetails.Role = Convert.ToString(row["role"]);
                    else
                        UserDetails.Role = ""; // or null

                    Console.ReadLine();
                    UserResult.Add(UserDetails);
                }
            }
            catch (Exception exc)
            {

                Console.Error.WriteLine(exc.Message);
            }
            finally { _conn.Close(); }

            return UserResult;
        }

        public string GetScannedBarcode(string CodeResult)
        {
            string result = "";

            try
            {
                _conn.Open();
                MySqlCommand ScanBarcode = _conn.CreateCommand();
                ScanBarcode.CommandText = "SELECT name, barcode, price FROM products WHERE barcode = @Barcode";
                ScanBarcode.Parameters.AddWithValue("@Barcode", CodeResult);

                using (MySqlDataReader reader = ScanBarcode.ExecuteReader())
                {
                    if (reader.Read())
                    {
                        string name = reader.GetString(0); // Assuming the name column is at index 0
                        string barcode = reader.GetString(1);
                        decimal price = reader.GetDecimal(2);

                        // Do something with the data
                        result = $"{name} - {barcode} - {price}";
                    }
                }
            }
            catch (Exception)
            {
                // Handle the exception if necessary
            }
            finally
            {
                _conn.Close();
            }

            return result;
        }

    }
}
