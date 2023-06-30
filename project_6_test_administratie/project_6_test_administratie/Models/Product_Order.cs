using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace project_6_test_administratie.Models
{
    public class Product_Order
    {
        private int id;

        public int Id
        {
            get { return id; }
            set { id = value; }
        }

        private int product_id;

        public int Product_id
        {
            get { return product_id; }
            set { product_id = value; }
        }

        private int order_id;

        public int Order_id
        {
            get { return order_id; }
            set { order_id = value; }
        }

        public int amount;

        public int Amount
        {
            get { return amount; }
            set { amount = value; }
        }

    }
}
