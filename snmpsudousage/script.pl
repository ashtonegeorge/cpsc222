#!/usr/bin/env perl

my $sudoCount = 0;

my $log = '/var/log/auth.log';

open(my $fh, '<', $log)
	or die "Cannot open $log: $!"; 

while(my $line = <$fh>) {
	if($line =~ /\bsudo:/) {
		$sudoCount++;
	}
}

close($fh);

print"$sudoCount\n"

