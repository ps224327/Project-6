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
            set { _selectedProduct = value; OnPropertyChanged(); }
        }


        public MainWindow()
        {
            InitializeComponent();
            DataContext = this;
        }
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

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {
            var token = "19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ";
            ReadApiAsync(token);
        }

        private void BtnAdd_Click(object sender, RoutedEventArgs e)
        {
            TextBlock printTextBlock = new TextBlock();
            printTextBlock.Text = SelectedProduct.Name;
            SpOrder.Children.Add(printTextBlock);
        }
    }
}
