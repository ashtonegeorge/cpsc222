#!/usr/bin/env perl
use strict;
use warnings;
open STDERR, '>', '/dev/null';

my $sudoCount = 0;

my $log = '/var/log/auth.log';

open(my $fh, '<', $log)
	or die "Cannot open $log: $!"; 

while(my $line = <$fh>) {
	if($line =~ /session opened for user (\S+) by (\S+)/) {
		$sudoCount++;
	}
}

close($fh);

print"$sudoCount";
exit 0;

