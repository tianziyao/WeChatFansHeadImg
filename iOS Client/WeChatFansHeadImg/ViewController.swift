//
//  ViewController.swift
//  WeChatFansHeadImg
//
//  Created by 田子瑶 on 16/9/3.
//  Copyright © 2016年 田子瑶. All rights reserved.
//

import UIKit

class ViewController: UIViewController {


    @IBOutlet weak var showHeadImageButton: UIButton!

    @IBOutlet var headImageViews: [UIImageView]!
    
    @IBAction func showHeadImageButtonDidTouch(sender: AnyObject) {
        
        getWechatFansHeadImgs()
        
    }

    override func viewDidLoad() {
        super.viewDidLoad()
        
        showHeadImageButton.layer.cornerRadius = 5
        
    }
    
    func getWechatFansHeadImgs() {
        
        self.pleaseWait()
        
        //let request = NSURLRequest(URL: NSURL(string: "http://localhost:8888/i/wechat/getuserinfo.php")!)
        let request = NSURLRequest(URL: NSURL(string: "http://123.206.27.127/wechat/getuserinfo.php")!)

        let task = NSURLSession.sharedSession().dataTaskWithRequest(request) { (data, resp, error) in
            
            if error != nil {
                print(error?.localizedDescription)
            }
            else {
                //let imgLinks = NSKeyedUnarchiver.unarchiveObjectWithData(data!) //nil
                //let strimgLinks = String(data: data!, encoding: NSUTF8StringEncoding) //PHP格式数组
                //print(strimgLinks!)
                var imgLinks: [String] = []
                let readingOprions = NSJSONReadingOptions.MutableContainers
                imgLinks = try! NSJSONSerialization.JSONObjectWithData(data!, options: readingOprions) as! Array//nil
                print(imgLinks)
                
                for i in 0..<imgLinks.count {
                    if imgLinks[i] != "" {
                        let data = NSData(contentsOfURL: NSURL(string: imgLinks[i])!)
                        dispatch_async(dispatch_get_main_queue(), {
                            self.headImageViews[i].image = data != nil ? UIImage(data: data!) : UIImage(named: "QRCode")
                            print(i)
                        })
                    }
                }
                
                
                print(NSThread.currentThread())
                dispatch_async(dispatch_get_main_queue(), {
                    self.clearAllNotice()
                    self.noticeOnlyText("Uh oh,他好可怜没有粉丝，你来关注一下它吧~", autoClear: true, autoClearTime: 2)
                })
            }
        }
        task.resume()
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }


}

