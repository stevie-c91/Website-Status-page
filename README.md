## Website Status page

A dynamic website status page, showing uptime/downtime statistics. This makes use of the [Uptime Robot](https://uptimerobot.com) API for monitoring.

Add your API Key from Uptime Robot on line 4 of 'monitoring.php' and you are good to go:

<pre><code>$api_key = 'REPLACE_WITH_YOUR_KEY';</code></pre>

This can be run locally with <code>vagrant up</code>.

You should run the following to install the required Vagrant plugins:

<pre><code>$ vagrant plugin install vagrant-hostmanager</code></pre>
<pre><code>$ vagrant plugin install vagrant-triggers</pre></code>

The Vagrant box being used is [Scotchbox Pro](https://box.scotch.io/pro).

![Monitoring page example](https://stevencotterill.co.uk/img/monitoring-page.jpg)