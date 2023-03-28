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

namespace kasssa
{
    /// <summary>
    /// Interaction logic for scanner.xaml
    /// </summary>
    public partial class scanner : Window
    {
        public scanner()
        {
            InitializeComponent();
        }

         public BitmapImage myBitMapImage;

        private void RunScanner(object e)
        {
            IMGCam.Source = myBitMapImage;



        }
    }
}
