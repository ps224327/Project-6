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

namespace project_6_test_administratie
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
            var token = "19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ";
            var result = ReadApiAsync(token).Result;
            listView.ItemsSource = result;
        }
        private async Task<List<Product>> ReadApiAsync(string token)
        {
            using (var client = new HttpClient())
            {
                client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", token);
                var response = await client.GetAsync("https://kuin.summaict.nl/api/product");
                var content = await response.Content.ReadAsStringAsync();
                var data = JsonConvert.DeserializeObject<List<Product>>(content);
                return data;
            }
        }
         
        private class Product
        {
            public string Name { get; set; }
        }
    }
}
