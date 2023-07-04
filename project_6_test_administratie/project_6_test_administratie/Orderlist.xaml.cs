using System;
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
using System.Collections.Specialized;
using System.ComponentModel;
using System.Runtime.CompilerServices;
using Org.BouncyCastle.Asn1.X509;

namespace project_6_test_administratie
{
    /// <summary>
    /// Interaction logic for Orderlist.xaml
    /// </summary>
    public partial class Orderlist : Window ,INotifyPropertyChanged
    {
        public event PropertyChangedEventHandler PropertyChanged;
        protected void OnPropertyChanged([CallerMemberName] string name = null)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(name));
        }

        private ObservableCollection<Models.Order> orders = new ObservableCollection<Models.Order>();
        public ObservableCollection<Models.Order> Orders
        {
            get { return orders; }
            set { orders = value; }
        }

        private Order _selectedOrder;

        public Order SelectedOrder
        {
            get { return _selectedOrder; }
            set
            {
                _selectedOrder = value;
                OnPropertyChanged();
            }
        }

        public Orderlist()
        {
            InitializeComponent();
            filldatagrid();
        }

        GroeneVingersDb _conn = new GroeneVingersDb();
        
        private void filldatagrid()
        {
            lvOrder.ItemsSource = _conn.GetAllOrders();
        }

        private void btnUpdate_Click(object sender, RoutedEventArgs e)
        {
            GroeneVingersDb db = new GroeneVingersDb();
            Order order = new Order();
            Product_Order product_order = new Product_Order();
            var selectedItem = lvOrder.SelectedItem as Order;                       
            int newStockValue = product_order.amount;

            //MessageBox.Show(newStockValue.ToString());

            //db.UpdateStock(newStockValue, order);

            //MessageBox.Show(selectedItem.Name);
        }
    }
}
