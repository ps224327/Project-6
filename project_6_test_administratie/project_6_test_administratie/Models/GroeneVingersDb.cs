﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;
using MySql.Data;
using System.Configuration;
using System.Data;
using System.Windows.Controls;
using project_6_test_administratie.Models;
using MySqlX.XDevAPI;
using MySqlX.XDevAPI.Common;

namespace project_6_test_administratie.Models
{
     class GroeneVingersDb
    {
        MySqlConnection _conn = new MySqlConnection("Server=localhost; Database=groenevingers; Uid=root; Pwd=;");

        public List<Order> GetAllOrders()
        {
            List<Order> result = new List<Order>();
            try
            {
                _conn.Open();
                MySqlCommand mySql = _conn.CreateCommand();
                mySql.CommandText = "SELECT id, name, status, total_price FROM kuin_order ORDER by id";
                MySqlDataReader reader = mySql.ExecuteReader();
                DataTable table = new DataTable();
                table.Load(reader);


                foreach (DataRow rij in table.Rows)
                {
                    Order orders = new Order();
                    orders.Id = (int)rij["id"];                         
                    orders.Name = (string)rij["name"];        
                    orders.Status = (string)rij["status"];          
                    orders.TotalPrice = (decimal)rij["total_price"];

                    result.Add(orders);
                }
            }
            catch (Exception e)
            {
                Console.Error.WriteLine(e.Message);
                return null;
            }
            finally
            {
                if (_conn.State == ConnectionState.Open)
                {
                    _conn.Close();
                }
            }

            return result;
        }

        public bool InsertOrder(Order order)
        {
            bool result = true;
            try
            {
                if (_conn.State == ConnectionState.Closed)
                {
                    _conn.Open();
                }
                MySqlCommand mySql = _conn.CreateCommand();
                mySql.CommandText =
                    @"INSERT INTO kuin_order
                        (name, total_price)
                        VALUES
                        (@name, @price);";

                //mySql.CommandText =
                //    @"INSERT INTO kuin_product_order
                //        (product_id, order_id, amount)
                //        VALUES
                //        (@product_id, @order_id, @amount);";

                mySql.Parameters.AddWithValue("@name", order.Name);
                mySql.Parameters.AddWithValue("@price", order.TotalPrice);
                mySql.ExecuteNonQuery();
            }
            catch (Exception e)
            {
                Console.WriteLine("***InsertIntoMenuItems***");
                Console.WriteLine(e.Message);
                result = false;
            }
            finally
            {
                if (_conn.State == ConnectionState.Open)
                {
                    _conn.Close();
                }
            }
            return result;
        }

        //// Create an instance of the class with UpdateStock
        //GroeneVingersDb _db = new GroeneVingersDb();

        //// Call the UpdateStock function
        //int recordId = 1; // Example record ID
        //int newStockValue = 100; // Example new stock value
        //_db.UpdateStock(recordId, newStockValue);
        public void UpdateStock(int recordId, int newStockValue)
        {
            try
            {
                _conn.Open();
                MySqlCommand command = _conn.CreateCommand();
                command.CommandText = "UPDATE products SET stock = @newStock WHERE id = @recordId";
                command.Parameters.AddWithValue("@newStock", newStockValue);
                command.Parameters.AddWithValue("@recordId", recordId);
                command.ExecuteNonQuery();
            }
            catch (Exception e)
            {
                Console.Error.WriteLine(e.Message);
            }
            finally
            {
                if (_conn.State == ConnectionState.Open)
                {
                    _conn.Close();
                }
            }
        }
    }
}
