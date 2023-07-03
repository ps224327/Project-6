using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.ComponentModel;
using System.Runtime.CompilerServices;

namespace project_6_test_administratie.Models
{
    public class Product: INotifyPropertyChanged
    {
        public event PropertyChangedEventHandler PropertyChanged;
        protected void OnPropertyChanged([CallerMemberName] string name = null)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(name));
        }



        public string Height
        {
            get { return IsCm ? $"{height_cm} cm" : $"{height_cm / 100.0} m"; }
        }


        public string Width
        {
            get { return IsCm ? $"{width_cm} cm" : $"{width_cm / 100.0} m"; }
        }


        public string Depth
        {
            get { return IsCm ? $"{depth_cm} cm" : $"{depth_cm / 100.0} m"; }
        }

        private bool isCm = true;
        public bool IsCm { 
            get => isCm; 
            set { 
                isCm = value; 
                OnPropertyChanged("Height");
                OnPropertyChanged("Width");
                OnPropertyChanged("Depth");
            }
        }

        public int id;
        public int Id
        {
            get { return id; }
            set { id = value; }
        }
        public string name;
        public string Name
        {
            get { return name; }
            set { name = value; }
        }
        public string description;
        public string Description
        {
            get { return description; }
            set { description = value; }
        }
        public decimal price;
        public decimal Price
        {
            get { return price; }
            set { price = value; }
        }
        public string image;
        public string Image
        {
            get { return image; }
            set { image = value; }
        }
        public string color;
        public string Color
        {
            get { return color; }
            set { color = value; }
        }
        public int height_cm;
        public int Height_cm
        {
            get { return height_cm; }
            set { height_cm = value; }
        }

        public int width_cm;
        public int Width_cm
        {
            get { return width_cm; }
            set { width_cm = value; }
        }
        public int depth_cm;
        public int Depth_cm
        {
            get { return depth_cm; }
            set { depth_cm = value; }
        }
        public int weight_gr;

        public int Weight_gr
        {
            get { return weight_gr; }
            set { weight_gr = value; }
        }
        public int stock;

        public int Stock
        {
            get { return stock; }
            set { stock = value; }
        }
    }
}
