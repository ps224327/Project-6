using AForge.Video.DirectShow;
using kasssa.Models;
using System;
using System.Collections.Generic;
using System.Data;
using System.Diagnostics;
using System.Drawing;
using System.Drawing.Imaging;
using System.IO;
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
using ZXing;

namespace kasssa
{
    /// <summary>
    /// Interaction logic for scanner.xaml
    /// </summary>
    public partial class scanner : Window
    {
        ProjectDB _db = new ProjectDB();
        public scanner()
        {
            InitializeComponent();
      
        }


        public string BarcodeNumbers { get; private set; }

        FilterInfoCollection filterInfoCollection;
        VideoCaptureDevice videoCaptureDevice;


        
        private void Scanner_load(object sender, EventArgs e)
        {
            filterInfoCollection = new FilterInfoCollection(FilterCategory.VideoInputDevice);
            foreach (FilterInfo device in filterInfoCollection)
            {
                CBCams.Items.Add(device.Name);
                CBCams.SelectedIndex = 0;
            }
      
        }
        private void RunScanner(object sender, EventArgs e)
        {
            videoCaptureDevice = new VideoCaptureDevice(filterInfoCollection[CBCams.SelectedIndex].MonikerString);
            videoCaptureDevice.NewFrame += VideoCaptureDevice_NewFrame;
            videoCaptureDevice.Start();
           


        }
        private void StopScanner (object sender, EventArgs e)
        {
            IMGCam.Source = null;
            this.Close();

        }


        private void VideoCaptureDevice_NewFrame(object sender, AForge.Video.NewFrameEventArgs eventArgs)
        {

            Bitmap bitmap = (Bitmap)eventArgs.Frame.Clone();
            BarcodeReader reader = new BarcodeReader();
            var BarCodeResult = reader.Decode(bitmap);
            if (BarCodeResult != null)
            {
                Application.Current.Dispatcher.Invoke(() =>
                {
                    string CodeResult = BarCodeResult.ToString();
              
                    //get data from the database using the barcode string
                    string isBarcodeFound = _db.GetScannedBarcode(CodeResult);
                    if (isBarcodeFound != "")
                    {
                    
                        
                            BarcodeNumbers = BarCodeResult.ToString();
                            IMGCam.Source = null;
                            this.Close();
                       
                        //BarcodeNumbers will be passed to the main window
                       
                    }
                    else
                    {
                        MessageBox.Show("Barcode not found: error");
                    }
                    
                 
                });

            }
            var bitmapImage = new BitmapImage();
            using (var stream = new MemoryStream())
            {
                bitmap.Save(stream, ImageFormat.Bmp);
                stream.Position = 0;
                bitmapImage.BeginInit();
                bitmapImage.CacheOption = BitmapCacheOption.OnLoad;
                bitmapImage.StreamSource = stream;
                bitmapImage.EndInit();
            }
            bitmapImage.Freeze();
            IMGCam.Dispatcher.Invoke(() =>
            {
                IMGCam.Source = bitmapImage;
            });
           
        }

        public void Scanned_barcode(object sender, RoutedEventArgs e)
        {
            
        }
    }
  
}
