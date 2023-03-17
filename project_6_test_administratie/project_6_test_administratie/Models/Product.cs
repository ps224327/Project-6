using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace project_6_test_administratie.Models
{
    internal class Product
    {
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
        //public int Price { get; set; }
        //public int Image { get; set; }
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
    }
}
