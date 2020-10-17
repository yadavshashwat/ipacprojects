def send_reset_link_html(name,link):
    html = '<html><head>'
    html = html + '</head>'
    html = html + '<body style="font-family: Arial; font-size: 12px;">'
    html = html + '<div>'
    html = html + 'Hi ' + name + ',<br>'
    html = html + '<p>Someone requested a password reset for your email ID. No changes have been done yet.' \
           ' Please follow the link below to reset your password.</p>'
    html = html + '<p>'
#    html = html + '<a href="'+ link +'">Follow this link to reset your password.</a>'
    html = html + "<a href=" + link + "><button style='border-radius:17px; background-color:#fadb44; height:34px; width:96px; '>Reset Link</button></a>"
    html = html + '</div></body></html>'
    return html

def pta_email(name):
    body = """
      <html>
      <body>
      <p style="font-weight: 400;"> Dear """ + str(name) + """,</p>
      <p style="font-weight: 400;">As the two-month long journey of the the National Agenda Forum comes to an end &ndash; we have reached an important milestone as we declare the<span>&nbsp;</span><strong>NAF Results.</strong></p>
    <p style="font-weight: 400;">The results can be<span>&nbsp;</span>accessed here -<span>&nbsp;</span><a href="http://www.indianpac.com/naf" data-saferedirecturl="https://www.google.com/url?hl=en&amp;q=http://www.indianpac.com/naf&amp;source=gmail&amp;ust=1536149832292000&amp;usg=AFQjCNEov7VJY1XnJEkfQ0Y2bYYJ1AGJBg"><strong>www.indianpac.com/naf</strong></a><strong>.<span>&nbsp;</span></strong>We have also attached the&nbsp;<strong>NAF Results Summary</strong><span>&nbsp;</span>along with this email.</p>
    <p style="font-weight: 400;"></p>
    <p style="font-weight: 400;">We are excited to share that more than<span>&nbsp;</span><strong>57 Lac people</strong><span>&nbsp;</span>have participated in the online voting process of NAF, and used the platform to set an agenda for contemporary India. The success of NAF was possible because of collaborative efforts of the entire NAF ecosystem most importantly its<span>&nbsp;</span><strong>1 Lakh+ Part Time Associates (PTAs), from 7500+ colleges,</strong><span>&nbsp;</span><strong>364 distinguished personalities</strong>&nbsp;and<span>&nbsp;</span><strong>343 civil society organizations</strong>.&nbsp;</p>
    <p style="font-weight: 400;"></p>
    <p style="font-weight: 400;">NAF would not have gained this momentum without you and for this - we are truly grateful.&nbsp;We look forward to working with you to take the people's agenda to the masses and keep them engaged and informed on the key priorities of the nation rooted in Gandhian ideals.</p>
    <p style="font-weight: 400;"></p>
    <p style="font-weight: 400;">Thanks</p>
    <p style="font-weight: 400;"></p>
    <p>Indian Political Action Committee&nbsp;</p>
    <p></p>
    <p><a href="http://www.indianpac.com">www.indianpac.com</a></p>
    <p><a href="http://www.facebook.com/IndianPAC">www.facebook.com/IndianPAC</a></p>
    <p><a href="http://www.twitter.com/IndianPAC">www.twitter.com/IndianPAC</a></p>
      </p>
      </body>
      </html>
    """
    return body
