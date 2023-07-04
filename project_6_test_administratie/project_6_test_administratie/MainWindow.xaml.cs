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
using System.Windows.Navigation;
using System.Windows.Shapes;
using System.Net.Http;
using Newtonsoft.Json;
using System.Net.Http.Headers;
using project_6_test_administratie.Models;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Runtime.CompilerServices;
using Pluralize.NET;
using System.Globalization;
using Org.BouncyCastle.Asn1.X509;

namespace project_6_test_administratie
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window ,INotifyPropertyChanged
    {      
        public event PropertyChangedEventHandler PropertyChanged;
        protected void OnPropertyChanged([CallerMemberName] string name = null)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(name));
        }

        private ObservableCollection<Product> _products = new ObservableCollection<Product>();

        public ObservableCollection<Product> Products
        {
            get { return _products; }
            set { _products = value; }
        }

        private Product _selectedProduct;

        public Product SelectedProduct
        {
            get { return _selectedProduct; }
            set {
                btnConvert.Content = value.IsCm ? "Naar meters" : "Naar centimeters" ;
                _selectedProduct = value;
                OnPropertyChanged(); 
            }
        }
        decimal Tprice;
        decimal Oprice;
        TextBlock putId = new TextBlock();
        TextBlock putAmount = new TextBlock();



        public MainWindow()
        {
            InitializeComponent();
            DataContext = this;
        }

        

        //IPluralize pluralizer = new Pluralizer();



        //Connect to the api
        private async Task ReadApiAsync(string token)
        {
            using (var client = new HttpClient())
            {
                client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", token);
                var response = await client.GetAsync("https://kuin.summaict.nl/api/product");
                var content = await response.Content.ReadAsStringAsync();
                var data = JsonConvert.DeserializeObject<List<Product>>(content);
                data.ForEach(data => { Products.Add(data); });
            }
        }

        //Send the token to the api
        private void Window_Loaded(object sender, RoutedEventArgs e)
        {
            var token = "19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ";
            ReadApiAsync(token);
        }

        //Add the selected item to the orderlist
        private void BtnAdd_Click(object sender, RoutedEventArgs e)
        {
            int quantity;

            if (string.IsNullOrEmpty(TbDetailId.Text))
            {
                MessageBox.Show("Selecteer eerst een artikel.");
                return;
            }

            if (!int.TryParse(QuantityTextBox.Text, out quantity) || quantity <= 0)
            {
                MessageBox.Show("Geef een aantal op.");
                return;
            }

            StackPanel orderItem = InitializeOrderItem(quantity);

            SpOrder.Children.Add(orderItem);
            //itemsToOrder.add(SelectedProduct.Id);

        }

        //Put the order row together 
        private StackPanel InitializeOrderItem(int quantity)
        {
            Pluralizer pluralizer = new Pluralizer();
            TextBlock printTextBlock = new TextBlock();
            TextBlock quantityTextBlock = new TextBlock();
            TextBlock price = new TextBlock();
            TextBlock times = new TextBlock();
            StackPanel orderItem = new StackPanel();

            orderItem.Orientation = Orientation.Horizontal;

            quantityTextBlock.Text = quantity.ToString();
            //printTextBlock.Text = SelectedProduct.Name;
            putId.Text = SelectedProduct.id.ToString();
            putAmount.Text = QuantityTextBox.Text.ToString();
            times.Text = "x ";


            string word = SelectedProduct.Name;
            int amount = int.Parse(QuantityTextBox.Text);
            string plural = (amount == 1) ? word : pluralizer.Pluralize(word);
            //myResultLabel.Content = $"{amount} {plural}";
            printTextBlock.Text = plural;

            price_calculator(null, null, quantity);
            price.Text = " €" + Tprice.ToString();
            putId.Visibility = Visibility.Collapsed;
            putAmount.Visibility = Visibility.Collapsed;
            orderItem.Children.Add(quantityTextBlock);
            orderItem.Children.Add(times);
            orderItem.Children.Add(printTextBlock);
            orderItem.Children.Add(price);

            QuantityTextBox.Clear();

            return orderItem;
        }

        //Convert the cm to meters
        private void btnConvert_Click(object sender, RoutedEventArgs e)
        {
            SelectedProduct.IsCm = btnConvert.Content.ToString() != "Naar meters";

            if(btnConvert.Content.ToString() == "Naar meters")
            {
                btnConvert.Content = "Naar centimeters";
            }

            else if (btnConvert.Content.ToString() == "Naar centimeters")
            {
                btnConvert.Content = "Naar meters";
            }

        }

        private void price_calculator(object sender, RoutedEventArgs e, int quantity)
        {
            decimal Pprice = SelectedProduct.Price;                      

            Tprice = Pprice * quantity;

            Oprice = Oprice + Tprice;

            tbTotaalPrijs.Text = "Totaal prijs: €" + Oprice.ToString();
            
        }

        private void Button_Click_1(object sender, RoutedEventArgs e)
        {
            Orderlist ord = new Orderlist();
            ord.Show();
        }

        private void btnOrder_Click_1(object sender, RoutedEventArgs e/*, int quantity*/)
        {
            GroeneVingersDb _db = new GroeneVingersDb();
            try
            {
                int PId = Convert.ToInt32(putId.Text);
                int PAmount = Convert.ToInt32(putAmount.Text);

                Order order = new Order();
                order.TotalPrice = Oprice;
                order.Name = tbName.Text;

                Product_Order product_Order = new Product_Order();

                product_Order.Product_id = PId;
                //product_Order.Order_id = 4;                    //aanpassen
                product_Order.amount = PAmount;                                               //Porder.amount = quantity;

                string test = PId.ToString();
                //MessageBox.Show(test);

                if (tbName.Text != "")
                {
                    bool insertionResult = _db.InsertOrder(order, product_Order);

                    if (insertionResult)
                    {
                        MessageBox.Show("Bestelling voltooid");
                        tbName.Text = "";
                        SpOrder.Children.Clear();
                    }
                    else
                    {
                        MessageBox.Show("Bestelling kon niet worden voltooid");
                    }
                }
                else
                {
                    MessageBox.Show("Geef een naam op");
                }
            }
            catch
            {
                MessageBox.Show("U bestelling is leeg");
            }          
        }
    }
}
