﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using System.Data.SqlClient;
using project_6_test_administratie.Models;
using System.Collections.ObjectModel;

namespace project_6_test_administratie
{
    /// <summary>
    /// Interaction logic for Orderlist.xaml
    /// </summary>
    public partial class Orderlist : Window
    {
        private ObservableCollection<Models.Order> orders = new ObservableCollection<Models.Order>();
        public ObservableCollection<Models.Order> Orders
        {
            get { return orders; }
            set { orders = value; }
        }

        public Orderlist()
        {
            InitializeComponent();
            LoadData();
            filldatagrid();
        }

        GroeneVingersDb _conn = new GroeneVingersDb();
        
        private void filldatagrid()
        {
            lvOrder.ItemsSource = _conn.GetAllOrders();
        }

        private void LoadData()
        {
            //Order.Clear();
            //foreach (Models.Order menuItem in _conn.GetAllOrders())
            //{
            //    Order.Add(menuItem);
            //}
        }
    }
}
