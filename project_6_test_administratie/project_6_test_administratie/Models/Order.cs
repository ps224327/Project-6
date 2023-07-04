using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;

namespace project_6_test_administratie.Models
{
    public class Order
    {
        public event PropertyChangedEventHandler PropertyChanged;
        protected void OnPropertyChanged([CallerMemberName] string name = null)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(name));
        }

        private int id;

        public int Id
        {
            get { return id; }
            set { id = value; }
        }

        private string? name;

        public string Name
        {
            get { return name; }
            set { name = value; }
        }

        private string? status;

        public string Status
        {
            get { return status; }
            set { status = value; }
        }

        private decimal total_price;
        public decimal TotalPrice
        {
            get { return total_price; } 
            set { total_price = value; }
        }
        
    }
}
