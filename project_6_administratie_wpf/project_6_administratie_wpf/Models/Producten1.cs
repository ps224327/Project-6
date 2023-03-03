using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Linq;
using System.Net.Http;
using System.Runtime.ConstrainedExecution;
using System.Text;
using System.Threading.Tasks;

namespace project_6_administratie_wpf.Models
{
    class Products : INotifyPropertyChanged
    {
        private const string path = "https://kuin.summaict.nl/api/product";
        private ObservableCollection<Product> products = new ObservableCollection<Product>();


        public Products()
        {
            LoadProducten();
        }
        public ObservableCollection<Product> Products
        {
            get { return Products; }
            set
            {
                SetProperty<ObservableCollection<Product>>(ref products, value);
            }
        }

        public event PropertyChangedEventHandler PropertyChanged;

        public async Task LoadProducten()
        {
            Products = await getAllProducten();
        }

        public async Task<ObservableCollection<Product>> getAllProducten()
        {


            using (HttpClient client = new HttpClient())
            {
                HttpResponseMessage response = await client.GetAsync(path);

                products = await response.Content.ReadAsAsync<ObservableCollection<Product>>();
                return products;
            }

        }

    }
}

